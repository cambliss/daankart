<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Donation;
use App\Models\Page;
use App\Models\Product;
use App\Models\CampaignProduct;
use App\Models\DaanProject;
use App\Models\DaanCampaign;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function daanDetails(Request $request, $id)
    {
        $campaign = DaanCampaign::with('products')->find($id);
        if(!empty($campaign)) {
            $pageTitle = $campaign->campaign_title;
        } else {
            $pageTitle = 'Campaign Not Found';
        }
        //dd($campaign);
        return view('Template::campaign.daan_details', compact('campaign', 'pageTitle'));
    }

    public function getAllCampaigns(Request $request)
    {
        $query = DaanCampaign::query();
        if($request->search) {
            $query->where('campaign_title', 'like', '%'.$request->search.'%')
            ->orWhere('campaign_description', 'like', '%'.$request->search.'%')
            ->orWhere('beneficiary_type', 'like', '%'.$request->search.'%');
        }
        if($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if($request->date) {
            $query->whereDate('created_at', $request->date);
        }
        $campaigns  = $query->paginate(getPaginate());
        $pageTitle = 'All Campaigns';
        $categories = Category::active()->hasCampaigns()->orderBy('id', 'DESC')->get();
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'campaign')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::campaign.all', compact('pageTitle', 'campaigns', 'categories', 'sections', 'seoContents', 'seoImage'));
    }

    public function index()
    {
        $pageTitle = 'Campaigns';
        $campaigns = Campaign::running()->boundary()->with(['user.organization', 'donations', 'category'])->orderBy('id', 'DESC')->filters(request('category'));
        if (request()->slug) {
            $category  = Category::where('slug', request()->slug)->active()->firstOrFail();
            $campaigns = $campaigns->where('category_id', $category->id);
        }
        $campaigns  = $campaigns->paginate(getPaginate());
        $categories = Category::active()->hasCampaigns()->orderBy('id', 'DESC')->get();

        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'campaign')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        return view('Template::campaign.index', compact('pageTitle', 'campaigns', 'categories', 'sections', 'seoContents', 'seoImage'));
    }

    public function filterCampaign(Request $request)
    {
        $type  = '';
        $query = Campaign::active()->running()->boundary()->with(['user.organization', 'donations', 'category']);

        if ($request->search) {
            $query =   $query->searchable(['title']);
        }

        if ($request->category_id) {
            $query = $query->where('category_id', $request->category_id);
            $type  = Category::where('id', $request->category_id)->first()->name;
        }

        if ($request->checkbox == 'urgent') {
            $query =   $query->whereDate('deadline', '>', now())
                ->whereDate('deadline', '<=', Carbon::now()->addDays(7));
            $type = 'Urgent';
        } else if ($request->checkbox == 'feature') {
            $query = $query->where('featured', Status::YES);
            $type  = 'Featured';
        } else if ($request->checkbox == 'top') {
            $campaigns =  $query->select('campaigns.*')->addSelect([
                'donations_sum' => Donation::select(DB::raw("SUM(donation)"))
                    ->whereColumn('campaign_id', 'campaigns.id')
                    ->paid()
                    ->take(12)
            ])->orderBy('donations_sum', 'DESC')->get();
            $type = 'Top';
            return view('Template::partials.campaign', compact('campaigns', 'type'));
        }

        if ($request->date) {
            $query =  $query->whereDate('created_at', '>=', $request->date);
        }
        $campaigns =  $query->orderBy('id', 'DESC')->get();
        return view('Template::partials.campaign', compact('campaigns', 'type'));
    }

    public function details($slug)
    {
        $user      = auth()->user();
        $isAdmin   = auth()->guard('admin')->check();
        $query     = Campaign::where('slug', $slug)->boundary();
        if (!$isAdmin) {
            if ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            } else {
                $query->running();
            }

            if (!$query->exists()) {
                $query = Campaign::where('slug', $slug)->running();
            }
        }

        $campaign     = $query->with('user', 'category', 'comments.user')->first();
        $products = CampaignProduct::where('campaign_id', $campaign->id)->get()->toArray();
        $daanproject = DaanProject::where('campaign_id', $campaign->id)->first();

        if (!$campaign) {
            $notify[] =  ['error', 'Campaign not found!'];
            return back()->withNotify($notify);
        }

        $pageTitle =  $campaign->title;

        //start-seo//
        $seoContents = $campaign->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('campaign', $seoContents->image, getFileSize('seo'), true) : null;

        $myFavorites = @auth()->user()?->favorites->pluck('campaign_id')->toArray();
        $products = Product::where('campaign_id', $campaign->id)->get();
        return view('Template::campaign.details', compact(
            'pageTitle', 'campaign', 'myFavorites', 'seoContents', 'seoImage', 'products',
            'products','daanproject'
        ));
    }

    public function comment(Request $request)
    {
        $request->validate([
            'campaign' => 'required|numeric',
            'review'   => 'required|min:5|max:2000',
        ]);

        $user = auth()->user();
        if (!$user) {
            $notify[] = ['error', 'Login is required for Campaign review'];
            return back()->withNotify($notify);
        }
        $comment = new Comment();
        $comment->user_id =  $user->id;
        $comment->campaign_id =   $request->campaign;
        $comment->review =   $request->review;
        $comment->save();

        $notify[] = ['success', 'Review added successfully, wait for admin approval'];
        return back()->withNotify($notify);
    }
    public function widget($id)
    {
        header("Access-Control-Allow-Origin: *");
        $campaign = Campaign::running()->boundary()->with(['donations', 'user.organization'])->find($id);
        if (!$campaign) {
            return;
        }
        $donation    = $campaign->donations->where('status', Status::DONATION_PAID)->sum('donation');
        $percent     = percent($donation, $campaign);
        $progressBar = progressPercent($percent > 100 ? '100' : $percent);
        $data = [
            'profile_name'     => $campaign->user->enable_org  ? $campaign->user->organization->name   :  $campaign->user->fullname,
            'user_image'       => getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')),
            'title'            => $campaign->title,
            'progress_percent' => showAmount($progressBar, currencyFormat: false),
            'description'      => strLimit($campaign->description, 95)
        ];
        return response()->json($data);
    }
public function store(Request $request)
{
    // Validate the uploaded video and campaign fields
    $request->validate([
        'video' => 'required|mimes:mp4,avi,mov|max:102400',  // Max 100MB
        'campaign_id' => 'nullable|exists:campaigns,id', // If provided, it must exist
        'title' => 'required|string|max:255',
        'category_id' => 'required|integer',
        'goal' => 'required|numeric',
        'goal_type' => 'required|string',
        'deadline' => 'required|date',
        'description' => 'nullable|string',
    ]);

    try {
        DB::beginTransaction(); // Start transaction

        if ($request->hasFile('video')) {
            // Ensure directory exists
            \Storage::disk('public')->makeDirectory('campaign_videos');

            // Store the video
            $videoPath = $request->file('video')->store('campaign_videos', 'public');

            // Debugging: Check if file is actually stored
            if (!\Storage::disk('public')->exists($videoPath)) {
                throw new \Exception("File upload failed: " . $videoPath);
            }

            \Log::info("Video stored at: " . $videoPath);

            // Check if updating an existing campaign
            if ($request->campaign_id) {
                $campaign = Campaign::find($request->campaign_id);
                $campaign->update(['video_link' => $videoPath]);
            } else {
                // Create a new campaign
                $campaign = Campaign::create([
                    'title' => $request->title,
                    'category_id' => $request->category_id,
                    'goal' => $request->goal,
                    'goal_type' => $request->goal_type,
                    'deadline' => $request->deadline,
                    'description' => $request->description,
                    'user_id' => auth()->id() ?? null, // Prevents error if user isn't logged in
                    'video_link' => $videoPath,
                ]);
            }
        } else {
            throw new \Exception("No video file detected in request.");
        }

        DB::commit(); // Commit transaction

        return redirect()->route('campaign.details', $campaign->id)
            ->with('success', 'Campaign created successfully!');
    } catch (\Exception $e) {
        DB::rollback(); // Rollback on error

        \Log::error("Video Upload Error: " . $e->getMessage());

        return back()->with('error', 'Something went wrong! ' . $e->getMessage());
    }
}


    public function thanksMessage($slug)
    {
        $pageTitle = 'Thank You';

        $user = auth()->user();
        if ($user) {
            $pageTitle = 'Thank You ' . @$user->fullname;
        }
        $campaign  = Campaign::where('slug', $slug)->first();
        $user      = $campaign->user;
        return view('Template::campaign.thanks_message', compact('pageTitle', 'campaign', 'user'));
    }
}
