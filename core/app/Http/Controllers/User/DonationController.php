<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function receivedDonation($campaignId = 0)
    {
        $pageTitle = "Received Donations";
        $donation  = Donation::paid()->whereHas('campaign', function ($q) {
            $q->where('user_id', auth()->id());
        });
        if ($campaignId) {
            $donation =  $donation->where('campaign_id', $campaignId);
        }
        $donations = $donation->with('deposit')->paginate(getPaginate());

        $given = 0;
        $campaignId =  $campaignId;
        return view('Template::user.donation.index', compact('donations', 'pageTitle', 'given', 'campaignId'));
    }

    public function givenDonation($campaignId = 0)
    {
        $pageTitle = "Given Donations";
        $donation  = Donation::paid()->where('user_id', auth()->id());
        if ($campaignId) {
            $donation =  $donation->where('campaign_id', $campaignId);
        }
        $given = true;
        $campaignId =  $campaignId;
        $donations = $donation->with('deposit')->paginate(getPaginate());
        return view('Template::user.donation.index', compact('donations', 'pageTitle', 'given', 'campaignId'));
    }

    public function details($id, $given)
    {
        $pageTitle = "Donor Information";
        $donor     = Donation::with('deposit', 'deposit.gateway:code,alias')->findOrFail($id);
        return view('Template::user.donation.details', compact('pageTitle', 'donor', 'given'));
    }

    public function donations($campaignId)
    {
        $pageTitle = "Campaign Donations Report";
        $donation  = Donation::whereHas('campaign', function ($q) {
            $q->where('user_id', auth()->id());
        });
        $donations = $donation->paid()->where('campaign_id', $campaignId)->with('deposit')->paginate(getPaginate(2));
        $campaignId =  $campaignId;
        return view('Template::user.donation.report', compact('donations', 'pageTitle', 'campaignId'));
    }


    public function donationReport(Request $request)
    {
        $chartData = [];
        $totalAmount = 0;

        if ($request->time == 'month') {
            foreach (getDaysOfMonth() as $day) {
                $dailyDonations = Donation::paid()
                    ->where('campaign_id', $request->campaign_id)
                    ->whereYear('created_at', now())
                    ->whereMonth('created_at', now())
                    ->whereDay('created_at', $day)
                    ->selectRaw('DATE(created_at) as date, count(*) as count, SUM(donation) as total')
                    ->groupBy('date')
                    ->first();

                $statusData['paid'] = $dailyDonations->count ?? 0;
                $chartData[$day] = $statusData;
                $totalAmount += $dailyDonations->total ?? 0;
            }
        }

        if ($request->time == 'week') {
            $startOfWeek = now()->startOfWeek()->toDateTimeString();
            $endOfWeek = now()->endOfWeek()->toDateTimeString();
            foreach (["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"] as $day) {
                $dailyDonations = Donation::paid()
                    ->where('campaign_id', $request->campaign_id)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->whereDay('created_at', dayNameToDate($day))
                    ->selectRaw('DATE(created_at) as date, count(*) as count, SUM(donation) as total')
                    ->groupBy('date')
                    ->first();
                $statusData['paid'] = $dailyDonations->count ?? 0;
                $chartData[$day] = $statusData;
                $totalAmount += $dailyDonations->total ?? 0;
            }
        }

        if ($request->time == 'year') {
            foreach (months() as $month) {
                $parsedMonth = Carbon::parse("1 $month");
                $monthlyDonations = Donation::paid()
                    ->where('campaign_id', $request->campaign_id)
                    ->whereYear('created_at', now())
                    ->whereMonth('created_at', $parsedMonth->month)
                    ->selectRaw('MONTH(created_at) as month, count(*) as count, SUM(donation) as total')
                    ->groupBy('month')
                    ->first();
                $statusData['paid'] = $monthlyDonations->count ?? 0;
                $chartData[$month] = $statusData;
                $totalAmount += $monthlyDonations->total ?? 0;
            }
        }

        // Return both chart data and the total amount
        return response()->json([
            'chart_data' => $chartData,
            'total_amount' => $totalAmount
        ]);
    }


    
}
