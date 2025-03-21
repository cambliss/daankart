<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\Campaign;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Exception;


class ManageCampaignController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Campaigns';
        $campaigns = Campaign::searchable(['title', 'category:name', 'user:username'])->with('user', 'category', 'donations')->withCount(['donations' => function ($query) {
            $query->paid();
        }])->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function details($id)
    {
        $campaign  = Campaign::with([
            'comments' => function ($q) {
                $q->take(5)->orderBy('id', 'DESC');
            }, 'donations' => function ($donation) {
                $donation->orderBy('id', 'DESC');
            }
        ])->withCount(['donations' => function ($query) {
            $query->paid();
        }])->findOrFail($id);

        $donate    = $campaign->donations->where('status', Status::DONATION_PAID)->sum('donation');
        $percent   = percent($donate, $campaign);

        if ($campaign->is_extend == Status::YES) {
            $pageTitle = "Campaign Extend Request Details";
        } else {
            $pageTitle = "Campaign Details";
        }

        return view('admin.campaign.details', compact('pageTitle', 'campaign', 'donate', 'percent'));
    }

    public function featured($id)
    {
        return Campaign::changeStatus($id, 'featured');
    }


    public function approveOrReject($status, $id)
    {
        $campaign = Campaign::pending()->find($id);
        if (!$campaign) {
            $campaign = Campaign::extended()->find($id);
            if (!$campaign) {
                $notify[] = ['error', 'The campaign data is invalid'];
                return back()->withNotify($notify);
            }
        }

        $user  = User::findOrFail($campaign->user_id);
        $general  = gs();

        if ($status == Status::CAMPAIGN_APPROVED) {
            $campaign->status = Status::CAMPAIGN_APPROVED;
            $notifyTemplate   = 'CAMPAIGN_APPROVE';
            $notification     = "Campaign approved successfully";
        } else {
            $campaign->status = Status::CAMPAIGN_REJECTED;
            $notifyTemplate   = 'CAMPAIGN_REJECT';
            $notification     = "Campaign rejected successfully";
        }

        if ($campaign->goal_type == Status::AFTER_DEADLINE) {
            $deadlineMode = showDateTime($campaign->deadline, 'd-m-Y');
        } elseif ($campaign->goal_type == Status::GOAL_ACHIEVE) {
            $deadlineMode = "Goal Achieve";
        } else {
            $deadlineMode = "Continuous";
        }

        notify($user, $notifyTemplate, [
            'campaign' => $campaign->title,
            'deadline' => $deadlineMode,
            'goal'     => $campaign->goal . ' ' . gs('cur_text'),
        ]);

        $campaign->save();
        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    //Approved is also running Campaign
    public function running()
    {
        $pageTitle = 'Running Campaigns';
        $campaigns = $this->campaignData('running');
        return view('admin.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Campaigns';
        $campaigns = $this->campaignData('pending');
        return view('admin.campaign.index', compact('campaigns', 'pageTitle'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Campaigns';
        $campaigns = $this->campaignData('rejected');
        return view('admin.campaign.index', compact('campaigns', 'pageTitle'));
    }
    public function completed()
    {
        $pageTitle = 'Successful Campaigns';
        $campaigns = $this->campaignData('success');
        return view('admin.campaign.index', compact('campaigns', 'pageTitle'));
    }
    public function expired()
    {
        $pageTitle = 'Expired Campaigns';
        $campaigns = $this->campaignData('expired');
        return view('admin.campaign.index', compact('campaigns', 'pageTitle'));
    }

    protected function campaignData($scope = null)
    {
        if ($scope) {
            if($scope == 'running'){
                $campaigns = Campaign::$scope()->boundary();
            }else{
                $campaigns = Campaign::$scope();
            }

        } else {
            $campaigns = Campaign::query();
        }
        return $campaigns->searchable(['title', 'category:name', 'user:username,firstname,lastname'])->with('user', 'category', 'donations')->withCount('donations')->orderBy('id', 'DESC')->paginate(getPaginate());
    }

    public function comments()
    {
        $pageTitle = "Campaign Reviews";
        $comments  = Comment::with('campaign', 'user')->searchable(['campaign:title', 'comment'])->filter(['campaign_id'])->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.campaign.comment', compact('pageTitle', 'comments'));
    }

    public function commentStatus($id)
    {
        return Comment::changeStatus($id);
    }

    public function campaignExtend()
    {
        $pageTitle       = 'Campaign Extended Request List';
        $campaigns       = $this->campaignData('extended');
        return view('admin.campaign.extend', compact('campaigns', 'pageTitle'));
    }

    public function delete($id)
    {
        $campaign = Campaign::findOrFail($id);
        User::findOrFail($campaign->user_id);
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
}
