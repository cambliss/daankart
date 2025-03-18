<?php

namespace App\Http\Controllers\User;

use Exception;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\DaanCampaign;
use App\Models\DaanProduct;
use App\Models\Document;
use App\Models\Category;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\CampaignUpdate;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function create(Request $request)
    {
        $pageTitle = 'Create New Campaign';
        $categories = Category::active()->orderBy('id', 'DESC')->get();
        if($request->has('id')) {
            $campaign = DaanCampaign::where('user_id', auth()->id())->where(function($query) {
                $query->where('is_kyc_varified', 0)->orWhereNull('is_kyc_varified');
            })->with('products')->find($request->id);
        } else {
            $campaign = DaanCampaign::where('user_id', auth()->id())->with('products')->first();
        }
        $user      = auth()->user();
        $isAdmin = $user->firstname == "admin";
        $step = ($request->step ?? 1);
        $id = ($request->id ?? 0);
        if($isAdmin) {
            return view('Template::admin.campaign.form', compact('pageTitle', 'categories','isAdmin','step','id','campaign'));
        } else {
            return view('Template::user.campaign.form', compact('pageTitle', 'categories','isAdmin','step','id','campaign'));
        }
    }

    public function storeCampaign(Request $request, $id = 0)
    {
       
        $this->validation($request, $id);
        $category = Category::active()->find($request->category_id);

        if (!$category) {
            $notify[] = ['error', 'Invalid campaign category!'];
            return back()->withNotify($notify);
        }

        if ($id) {
            $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);
            $campaign->donor_visibility  = $request->donor_visibility == "on" ? 1 : 0;
            $notification = 'Campaign updated successfully/waiting for admin approval.';
        } else {
            $campaign = new Campaign();
            $notification = 'Campaign created successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $path = getFilePath('campaign');
                $oldImage = '';
                $filename = fileUploader($request->image, $path, getFileSize('campaign'), $oldImage);

                if ($id) {
                    $deleteImage = $path . '/' . $campaign->image;
                    fileManager()->removeFile($deleteImage);
                }
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload campaign image.'];
                return back()->withNotify($notify);
            }
        }

        // video
        $video = "";
        if ($request->video) {
            $file = $request->file('video');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('videos'), $fileName); // Save to public/videos
            $video = 'videos/' . $fileName;
        }
        if ($request->image1) {
            $file = $request->file('image1');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName); // Save to public/images
            $image1 = 'images/' . $fileName;
        }

        if ($request->image2) {
            $file = $request->file('image2');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName); // Save to public/images
            $image2 = 'images/' . $fileName;
        }

        if ($request->image3) {
            $file = $request->file('image3');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName); // Save to public/images
            $image3 = 'images/' . $fileName;
        }

        if ($request->image4) {
            $file = $request->file('image4');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName); // Save to public/images
            $image4 = 'images/' . $fileName;
        }

        if ($request->image5) {
            $file = $request->file('image5');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName); // Save to public/images
            $image5 = 'images/' . $fileName;
        }

        if ($request->image6) {
            $file = $request->file('image6');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName); // Save to public/images
            $image6 = 'images/' . $fileName;
        }


        if ($request->hasFile('attachments')) {
            try {
                $path = getFilePath('proof');
                $size = getFileSize('proof');
                $proofFiles = [];
                foreach ($request->attachments as $key => $attachment) {
                    if ($attachment->getClientOriginalExtension() == 'pdf') {
                        $filename2 = uniqid() . time() . '.' . $attachment->getClientOriginalExtension();
                        $proof = [
                            "proof_$key" => $filename2,
                        ];
                        $proofFiles = $proofFiles + $proof;
                        $attachment->move($path, $filename2);
                    } else {
                        $image = [
                            "proof_$key" => fileUploader($attachment, $path, $size)
                        ];
                        $proofFiles =  $proofFiles + $image;
                    }
                }

                if ($id) {
                    foreach ($campaign->proof_images as $proof) {
                        $deleteProofPath = $path . '/' . $proof;
                        fileManager()->removeFile($deleteProofPath);
                    }
                }
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload proof attachment!'];
                return back()->withNotify($notify);
            }
        }

        $filename = @$filename ? $filename : $campaign->image;
        $proofData = @$proofFiles ? $proofFiles : $campaign->proof_images;
        $purifier = new \HTMLPurifier();

        $campaign->category_id  = $request->category_id;

        $campaign->user_id      = auth()->user()->id;
        $campaign->title        = $request->title;
        $campaign->description  = $purifier->purify($request->description);
        $campaign->goal         = $request->goal;
        $campaign->goal_type    = $request->goal_type;
        $campaign->deadline     = $campaign->goal_type == Status::AFTER_DEADLINE  ? Carbon::parse($request->deadline) : NULL;
        $campaign->image        = $filename;
        $campaign->video_link       = $video;
        $campaign->proof_images = $proofData;
        $campaign->slug         = slug($request->title);
        $campaign->textonvideo    = $request->textonvideo;
        $campaign->title2         = $request->title2;
        $campaign->image1         = $image1;
        $campaign->image2         = $image2;
        $campaign->image3         = $image3;
        $campaign->image4         = $image4;
        $campaign->image5         = $image5;
        $campaign->image6         = $image6;
        $campaign->text1         = $request->text1;
        $campaign->text2         = $request->text2;
        $campaign->text3         = $request->text3;

        $campaign->faqs = [
            'question' => $request->question,
            'answer' => $request->answer,
        ];


        $campaign->save();
         
        $products = [];
        foreach ($request->input('product_name') as $index => $productName) {
            $products[] = [
                'campaign_id' => $campaign->id, // Ensure you have this field
                'product_name' => $productName,
                'price' => $request->input('price')[$index],
                'quantity' => $request->input('quantity')[$index],
                'total_cost' => $request->input('total_cost')[$index],
                'comments' => $request->input('comments')[$index],
            ];
        }
        dd($request->all(),$products);
        // Now you can insert the products into the database
        foreach ($products as $product) {
            Product::create($product);
        }
    

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function saveCampaign(Request $request, $id = 0)
    {   $pageTitle = 'Create New Campaign';
        $categories = Category::active()->orderBy('id', 'DESC')->get();
        if($id == 0) {
            $campaign = new DaanCampaign();
        }else {
            $campaign = DaanCampaign::findOrFail($id);
        }
        $user      = auth()->user();
        $isAdmin = $user->firstname == "admin";
        $step = $request->step;
        $campaign->user_id = $user->id;
        if($step == 1 ){
            $request->validate([
                'cause' => 'required|string',
                'campaigner_name' => 'required|string',
                'mobile_number' => 'required|string',
                'email' => 'required|string'
            ]);
            $campaign->cause = $request->cause;
            $campaign->campaigner_name = $request->campaigner_name;
            $campaign->mobile_number = $request->mobile_number;
            $campaign->email = $request->email;
            $campaign->save();
        } else if($step == 2) {
            $request->validate([
                'beneficiary_type' => 'required|string',
                'beneficiary_name' => 'required|string',
                'beneficiary_location' => 'required|string',
                'beneficiary_mobile' => 'required|string',
            ]);
            $campaign->beneficiary_type = $request->beneficiary_type;
            $campaign->beneficiary_name = $request->beneficiary_name;
            $campaign->beneficiary_location = $request->beneficiary_location;
            $campaign->beneficiary_mobile = $request->beneficiary_mobile;
            $campaign->save();
        } else if($step == 3) {
            $request->validate([
                'campaign_title' => 'required|string',
                'campaign_description' => 'required|string',
                'campaign_image' => 'required|image',
            ]);
            $campaign->campaign_title = $request->campaign_title;
            $campaign->campaign_description = $request->campaign_description;
            $campaign->image = fileUploader($request->campaign_image, getFilePath('campaign'), getFileSize('campaign'));
            $campaign->save();
        } else if($step == 4){
            $request->validate([
                'product_list' => 'required|string',
            ]);
            $product_list = json_decode($request->product_list);
            // dd($product_list);
            foreach($product_list as $prod) {
                $product = new DaanProduct();
                $product->campaign_id = $campaign->id;
                $product->product_name = $prod->product_name;
                $product->price_per_unit = $prod->price;
                $product->required_quantity = $prod->quantity;
                $product->comments = $prod->comments ?? '';
                $product->save();
            }
            $campaign->status = "Completed";
            $campaign->save();
        }
        if($step < 4) $step = $step + 1;
        if($step != $campaign->tab) {
            $campaign->tab = $step;
            $campaign->save();
        }
        if($request->has('action') && $request->action == 'upload-kyc') {
            $request->validate([
                'kyc_document' => 'required|image',
                'document_type' => 'required|string',
            ]);
            $file = fileUploader($request->kyc_document, getFilePath('campaign'), getFileSize('campaign'));
            $document = new Document();
            $document->targetable_id = $campaign->id;
            $document->targetable_type = "App\Models\DaanCampaign";
            $document->file_type = $request->document_type;
            $document->file_path = $file;
            $document->file_ext = $request->kyc_document->getClientOriginalExtension();
            $document->file_size = $request->kyc_document->getSize();
            $document->uploaded_by = auth()->user()->id;
            $document->save();
            $campaign->is_kyc_varified = 1;
            $campaign->save();
        }
        return redirect()->route('user.campaign.fundrise.create', ['step' => $step, 'id' => $campaign->id]);
    }

    protected function validation($request, $id)
    {
        $image          = $id ? 'nullable' : 'required';
        $proofDocuments = $id ? 'nullable' : 'required';
        $deadlineRule = $request->goal_type == Status::AFTER_DEADLINE ? 'required|' : 'nullable|';

        $request->validate([
            'category_id'   => 'required|integer',
            'title'         => "required|max:255|unique:campaigns,title,$id,id",
            'description'   => 'required|string',
            'goal_type'     => 'required|numeric|in:1,2,3',
            'goal'          => 'required|numeric|gt:0',
            'deadline'      => $deadlineRule . 'date|after:today',
            'image'         => [$image, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'attachments.*' => [$proofDocuments, new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf']), 'max:5120'],
            'question.*'    => 'required|string',
            'answer.*'      => 'required|string',
            'textonvideo'   => 'required|string',
            'title2'        => 'required|string',
            'image1'        => 'required|image',
            'image2'        => 'required|image',
            'image3'        => 'required|image',
            'image4'        => 'required|image',
            'image5'        => 'required|image',
            'image6'        => 'required|image',
            'text1'         => 'required|string',
            'text2'         => 'required|string',
            'text3'         => 'required|string',
        ]);
    }

    public function extended(Request $request, $id = 0)
    {
        $campaign = Campaign::where('user_id', auth()->id())->where('id', $id)->expired()->first();

        if (!$campaign) {
            $notify[] = ['error', 'The request to extend the campaign is invalid'];
            return back()->withNotify($notify);
        }

        $request->validate([
            'goal'          => 'required|numeric|gte:0',
            'deadline'      => 'required|date|after:today',
            'final_goal'    => 'required|numeric|gt:0',
        ]);

        $campaign->deadline    = Carbon::parse($request->deadline);
        $campaign->goal        = $request->goal + $campaign->goal;
        $campaign->extend_goal = $request->goal;
        $campaign->is_extend   = Status::YES;
        $campaign->expired     = Status::NO;
        $campaign->status      = Status::PENDING;
        $campaign->save();
        $notify[] = ['success', 'The campaign extension request has been successfully submitted to the author.'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle  = "Edit Campaign ";
        $campaign   = Campaign::where('user_id', auth()->id())->findOrFail($id);
        $categories = Category::active()->get();
        return view('Template::user.campaign.edit', compact('pageTitle', 'campaign', 'categories'));
    }

    protected function campaignData($scope = null)
    {
        if ($scope) {
            $campaigns = Campaign::$scope();
        } else {
            $campaigns = Campaign::query();
        }
        return $campaigns->where('user_id', auth()->id())->searchable(['title'])->with('donations', 'category')->orderBy('id', 'DESC')->paginate(getPaginate());
    }

    public function approvedCampaign()
    {
        $pageTitle  = "Approved Campaigns";
        $campaigns  = $this->campaignData('running');
        return view('Template::user.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function pendingCampaign()
    {
        $pageTitle  = "Pending Campaigns";
        $campaigns = $this->campaignData('pending');
        return view('Template::user.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function rejectedCampaign()
    {
        $pageTitle  = "Rejected Campaigns";
        $campaigns = $this->campaignData('rejected');
        return view('Template::user.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function completeCampaign()
    {
        $pageTitle = "Successful Campaigns";
        $campaigns = $this->campaignData('success');
        return view('Template::user.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function expiredCampaign()
    {
        $pageTitle = "Expired Campaigns";
        $campaigns = $this->campaignData('expired');
        return view('Template::user.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function runAndStop($id)
    {
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);
        if ($campaign->stop) {
            $campaign->stop = Status::NO;
            $notification = 'Campaign started successfully';
        } else {
            $campaign->stop = Status::YES;
            $notification = 'Campaign stopped successfully';
        }
        $campaign->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function complete($id)
    {
        $campaign = Campaign::active()->findOrFail($id);
        $campaign->completed = Status::YES;
        $campaign->save();
        $notify[] = ['success', 'Campaign Completed Successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $campaign = Campaign::findOrFail($id);
        try {
            $path = getFilePath('campaign') . '/' . $campaign->image;
            if (!empty($campaign->proof_images)) {
                foreach ($campaign->proof_images as  $proof) {
                    $proofPath = getFilePath('proof') . '/' . $proof;
                    fileManager()->removeFile($proofPath);
                }
            }
            $campaign->delete();
            fileManager()->removeFile($path);
        } catch (Exception $ex) {
            $notify[] = ['error', $ex->getMessage()];
            return back()->withNotify($notify);
        }
        $notify[] = ['success', 'Campaign deleted Successfully'];
        return back()->withNotify($notify);
    }

    public function allCampaign()
    {
        $pageTitle = "All Campaigns";
        $campaigns = Campaign::searchable(['title'])->where('user_id', auth()->user()->id)->with('donations', 'category')->orderBy('id', "desc")->paginate(getPaginate());
        return view('Template::user.campaign.all', compact('pageTitle', 'campaigns'));
    }

    public function campaignUpdation($id)
    {
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);
        $pageTitle = $campaign->title;
        return view('Template::user.campaign.update', compact('pageTitle', 'campaign'));
    }

    public function campaignUpdationStore(Request $request, $id)
    {
        $request->validate([
            'updation' => 'required|string'
        ]);
        $campaign = Campaign::where('user_id', auth()->id())->findOrFail($id);

        $updation = CampaignUpdate::where('campaign_id', $campaign->id)->first();
        if (!$updation) {
            $updation = new CampaignUpdate;
        }
        $updation->campaign_id = $campaign->id;
        $updation->updation = $request->updation;
        $updation->save();
        $notify[] = ['success', 'Campaign updation successfully!'];
        return back()->withNotify($notify);
    }



    public function frontendSeo($id)
    {
        $data = Campaign::findOrFail($id);
        $pageTitle = 'SEO Configuration: ' . $data->title;
        return view('Template::user.campaign.frontend_seo', compact('pageTitle', 'data'));
    }



    public function frontendSeoUpdate(Request $request, $id)
    {

        $request->validate([
            'image' => ['nullable', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ]);

        $data = Campaign::findOrFail($id);
        $image = @$data->seo_content->image;
        if ($request->hasFile('image')) {
            try {
                $path = 'assets/images/frontend/campaign' . '/seo';
                $image = fileUploader($request->image, $path, getFileSize('seo'), @$data->seo_content->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the image'];
                return back()->withNotify($notify);
            }
        }
        $data->seo_content = [
            'image' => $image,
            'description' => $request->description,
            'social_title' => $request->social_title,
            'social_description' => $request->social_description,
            'keywords' => $request->keywords,
        ];
        $data->save();

        $notify[] = ['success', 'SEO content updated successfully'];
        return back()->withNotify($notify);
    }
}
