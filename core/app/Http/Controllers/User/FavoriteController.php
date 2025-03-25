<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $pageTitle = "My Favorite Campaigns";
        $favorites = Favorite::where('user_id', auth()->id())->searchable(['title'])->with('campaign.donations', 'campaign.category', 'campaign.user.organization')->orderBy('id', 'desc')->paginate(getPaginate());
        return view(  'Template::user.favorite', compact('pageTitle', 'favorites'));
    }

    public function add(Request $request)
    {
        $favorite = Favorite::where('campaign_id', $request->id)->where('user_id', auth()->id())->first();
        if ($favorite) {
            $favorite->delete();
            $action = "delete";
            $msg = "Remove favorite successfully!";
        } else {
            $favorite = new Favorite();
            $favorite->campaign_id = $request->id;
            $favorite->user_id = auth()->id();
            $favorite->save();
            $action = "add";
            $msg = "Make favorite successfully!";
        }
        return response()->json(
            [
                'action' => $action,
                'notification' => $msg
            ]
        );
    }
}
