<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationDonor;
use App\Models\OrganizationUpdate;
use App\Models\OrganizationAward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        return view('Template::user.profile.setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {
        $user = auth()->user();
        $imageRule =  $user->image ? 'nullable' : 'required';
        $request->validate([
            'firstname'   => 'required|string',
            'lastname'    => 'required|string',
            'image'       => [$imageRule, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cover'       => [$imageRule, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'description' => 'nullable|string|max:500',
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required' => 'The last name field is required'
        ]);


        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        if ($request->hasFile('cover')) {
            try {
                $old = $user->cover;
                $user->cover = fileUploader($request->cover, getFilePath('userCover'), getFileSize('userCover'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your cover image'];
                return back()->withNotify($notify);
            }
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;

        $purifier = new \HTMLPurifier();
        $user->description  = $purifier->purify($request->description);

        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view('Template::user.profile.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }


    public function organization()
    {
        $pageTitle = 'Organization Profile';
        $org = Organization::where('user_id', auth()->id())->first();
        return view('Template::user.profile.organization', compact('pageTitle', 'org'));
    }

    public function storeOrg(Request $request)
    {
        $user = auth()->user();
        $org = Organization::where('user_id', $user->id)->first();
        $imageRule = 'nullable';
        $notification = 'Organization profile updated successfully';
        if (!$org) {
            $org = new Organization();
            $imageRule =  'required';
            $notification = 'Organization profile added successfully';
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'mobile' => 'required|string',
            'address' => 'required|string',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => [$imageRule, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cover'       => [$imageRule, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        $user = auth()->user();
        $user->enable_org = $request->enable_org == "on" ? 1 : 0;
        $user->save();

        $org->user_id = $user->id;
        $org->name = $request->name;
        $org->tagline = $request->tagline;
        $org->description = $request->description;

        $org->address = [
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ];

        if ($request->hasFile('image')) {
            try {
                $old = $org->image;
                $org->image = fileUploader($request->image, getFilePath('orgProfile'), getFileSize('orgProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload image'];
                return back()->withNotify($notify);
            }
        }
        if ($request->hasFile('cover')) {
            try {
                $old = $org->cover;
                $org->cover = fileUploader($request->cover, getFilePath('orgCover'), getFileSize('orgCover'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload cover image'];
                return back()->withNotify($notify);
            }
        }

        $org->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }


    public function award()
    {
        $org =  Organization::where('user_id', auth()->id())->first();
        $pageTitle  = "Awards / Certifications";
        $awards = OrganizationAward::where('organization_id', @$org->id)->paginate(getPaginate());
        return view('Template::user.profile.award', compact('pageTitle', 'awards', 'org'));
    }


    public function storeAward(Request $request, $id = 0)
    {
        $org =  Organization::where('user_id', auth()->id())->first();
        if (!$org) {
            $notify[] = ['error', 'Firstly register an organization!'];
            return back()->withNotify($notify);
        }
        $imageRule =  $id ? 'nullable' : 'required';
        $request->validate([
            'title'        => 'required|string',
            'contribution' => 'required|string',
            'institute'    => 'required|string',
            'image'        => [$imageRule, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        if ($id) {
            $award     = OrganizationAward::where('organization_id', $org->id)->findOrFail($id);
            $notification = 'Award updated successfully';
        } else {
            $award     = new OrganizationAward();
            $notification = 'Award added successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $old = $award->image;
                $award->image = fileUploader($request->image, getFilePath('orgAward'), getFileSize('orgAward'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload award image'];
                return back()->withNotify($notify);
            }
        }
        $award->organization_id = $org->id;
        $award->title           = $request->title;
        $award->contribution    = $request->contribution;
        $award->institute       = $request->institute;
        $award->save();

        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function deleteAward($id)
    {
        $org   = Organization::where('user_id', auth()->id())->first();
        $award = OrganizationAward::where('organization_id', @$org->id)->findOrFail($id);
        unlink(getFilePath('orgAward') . '/' . $award->image);
        $award->delete();
        $notify[] = ['success',  'Award deleted successfully'];
        return back()->withNotify($notify);
    }


    public function donorWall()
    {
        $pageTitle = "Donor Wall";
        $org       = Organization::where('user_id', auth()->id())->first();
        $donors    = OrganizationDonor::where('organization_id', @$org->id)->paginate(getPaginate());
        return view('Template::user.profile.donor_wall', compact('pageTitle', 'donors', 'org'));
    }

    public function storeDonor(Request $request, $id = 0)
    {
        $user  = auth()->user();
        $org =  Organization::where('user_id', $user->id)->first();
        if (!$org) {
            $notify[] = ['error', 'Firstly register an organization!'];
            return back()->withNotify($notify);
        }

        $imageRule =  $id ? 'nullable' : 'required';
        $request->validate([
            'name'       => 'required|string',
            'details' => 'required|string',
            'image'       => [$imageRule, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        $user  = auth()->user();

        if ($id) {
            $donor     = OrganizationDonor::where('organization_id', $org->id)->findOrFail($id);
            $notification = 'Donor updated successfully';
        } else {
            $donor     = new OrganizationDonor();
            $notification = 'Donor added successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $old = $donor->image;
                $donor->image = fileUploader($request->image, getFilePath('orgDonor'), getFileSize('orgDonor'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload donor image'];
                return back()->withNotify($notify);
            }
        }

        $donor->organization_id = $org->id;
        $donor->name            = $request->name;
        $donor->details         = $request->details;
        $donor->save();
        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function deleteDonor($id)
    {
        $user      = auth()->user();
        $org       = Organization::where('user_id', $user->id)->first();
        $donors = OrganizationDonor::where('organization_id', $org->id)->findOrFail($id);
        unlink(getFilePath('orgDonor') . '/' . $donors->image);
        $donors->delete();
        $notify[] = ['success',  'Donor deleted successfully'];
        return back()->withNotify($notify);
    }

    public function organizationUpdate()
    {
        $pageTitle = 'Present Status';
        $org       = Organization::where('user_id', auth()->id())->first();
        $updates   = OrganizationUpdate::where('organization_id', @$org->id)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.profile.org_update', compact('pageTitle', 'updates', 'org'));
    }


    public function storeOrgUp(Request $request, $id = 0)
    {
        $user  = auth()->user();
        $org =  Organization::where('user_id', $user->id)->first();
        if (!$org) {
            $notify[] = ['error', 'Firstly register an organization!'];
            return back()->withNotify($notify);
        }
        $request->validate([
            'updation' => 'required|string',
            'date'     => 'required|date',

        ]);
        $user  = auth()->user();
        if ($id) {
            $update     = OrganizationUpdate::where('organization_id', $org->id)->findOrFail($id);
            $notification = 'organize updation update successfully';
        } else {
            $update     = new OrganizationUpdate();
            $notification = 'organize updation added successfully';
        }


        $update->organization_id = $org->id;
        $update->updation        = $request->updation;
        $update->date            = Carbon::parse($request->date);
        $update->save();
        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function deleteUpdate($id)
    {
        $user   = auth()->user();
        $org    = Organization::where('user_id', $user->id)->first();
        $update = OrganizationUpdate::where('organization_id', $org->id)->findOrFail($id);
        $update->delete();
        $notify[] = ['success',  'Donor deleted successfully'];
        return back()->withNotify($notify);
    }
}
