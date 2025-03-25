<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        $pageTitle = "Donation List";
        $donations = Donation::where('status',Status::DONATION_PAID)->orderBy('id', 'DESC')->searchable(['fullname', 'mobile', 'donation','email','country', 'campaign:title', 'deposit.gateway:name'])->filter(['anonymous'])->dateFilter()->with('campaign', 'deposit', 'deposit.gateway')->filter(['status'])->whereHas('campaign')->paginate(getPaginate());
        return view('admin.donation.index', compact('pageTitle', 'donations'));
    }

    public function campaignWiseDonations($campaignId)
    {
        $donations = Donation::where('status',Status::DONATION_PAID)->where('campaign_id', $campaignId)->orderBy('id', 'DESC')->searchable(['fullname', 'mobile', 'donation', 'campaign:title'])->with('campaign', 'deposit', 'deposit.gateway')->whereHas('campaign')->paginate(getPaginate());
        $pageTitle =  Campaign::where('id', $campaignId)->first()->title;
        return view('admin.donation.index', compact('pageTitle', 'donations'));
    }
}
