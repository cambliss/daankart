<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;

class ProfileController extends Controller
{
    public function index($username)
    {
        $user        = User::where('username', $username)->firstOrFail();
        $pageTitle   = $user->fullname . " " . "Profile";
        $campaigns   = Campaign::where('user_id', $user->id)->running()->boundary()->with(['user.organization', 'donations', 'category'])->orderBy('id', 'DESC')->paginate(getPaginate());
        $seoContents = $this->generateSeoContent($user);
        return view('Template::profile.campaign', compact('pageTitle', 'user', 'campaigns', 'seoContents'));
    }

    public function info($username)
    {
        $user      = User::where('username', $username)->firstOrFail();
        $pageTitle = $user->fullname . "'s" . " " . "Profile Info";
        $seoContents = $this->generateSeoContent($user);
        return view('Template::profile.info', compact('pageTitle', 'user', 'seoContents'));
    }

    public function award($username)
    {
        $user      = User::where('username', $username)->firstOrFail();
        $pageTitle = $user->fullname . "'s" . " " . "Profile Award";
        $seoContents = $this->generateSeoContent($user);
        return view('Template::profile.award', compact('pageTitle', 'user', 'seoContents'));
    }

    public function donor($username)
    {
        $user      = User::where('username', $username)->firstOrFail();
        $pageTitle    = $user->fullname . "'s" . " " . "Profile Donor Wall";
        $seoContents = $this->generateSeoContent($user);
        return view('Template::profile.donor_wall', compact('pageTitle', 'user', 'seoContents'));
    }

    public function update($username)
    {
        $user      = User::where('username', $username)->firstOrFail();
        $pageTitle    = $user->fullname . "'s" . " " . "Profile Update";
        $seoContents = $this->generateSeoContent($user);
        return view('Template::profile.update', compact('pageTitle', 'user', 'seoContents'));
    }

    protected function generateSeoContent($user)
    {
 
        $seoContents['keywords']           = [];
        $seoContents['social_title']       = @$user->organization->tagline ?? '';
        $seoContents['description']        = strLimit(strip_tags(@$user->organization->description ?? $user->description), 200);
        $seoContents['social_description'] = strLimit(strip_tags(@$user->organization->description ?? $user->description), 150);
        if ($user->enable_org) {
            $image  =  getImage(getFilePath('orgProfile') . '/' . $user->organization->image, '350x300');
        } else {
            $image  =  getImage(getFilePath('userProfile') . '/' . $user->image, '350x300');
        }
        $seoContents['image']              =  $image;
        $seoContents['image_size']         = '350x300';
        $seoContents['author']             = @$user->organization->name ?? @$user->user->fullname ?? '';
        $seoContents['email']              = @$user->organization->address->email ?? @$user->user->email;
        $seoContents['publishedAt']        = showDateTime(@$user->organization->created_at ?? $user->created_at);
        return $seoContents;
    }
}
