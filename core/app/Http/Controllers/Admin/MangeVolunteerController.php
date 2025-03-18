<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Models\NotificationTemplate;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class MangeVolunteerController extends Controller
{
    public function index()
    {
        $pageTitle  = "All Volunteers";
        $volunteers = Volunteer::searchable(['firstname', 'lastname', 'email', 'mobile', 'country'])->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.volunteer.index', compact('pageTitle', 'volunteers'));
    }
    public function status($id)
    {
        return Volunteer::changeStatus($id);
    }

    public function create()
    {
        $pageTitle = 'Create Volunteer';
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('admin.volunteer.details', compact('pageTitle', 'countries'));
    }

    public function details($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $pageTitle = 'Volunteer Detail - ' . $volunteer->fullname;
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('admin.volunteer.details', compact('pageTitle', 'volunteer', 'countries'));
    }

    public function update(Request $request, $id = 0)
    {
        if ($id) {
            $volunteer    = Volunteer::findOrFail($id);
            $notify[]     = ['success', 'Volunteer updated successfully'];
        } else {
            $volunteer    = new Volunteer();
            $notify[]     = ['success', 'Volunteer added successfully'];
        }
        $countryData  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray = (array)$countryData;
        $countries    = implode(',', array_keys($countryArray));
        $countryCode  = $request->country;
        $country      = $countryData->$countryCode->country;
        $dialCode     = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname'     => 'required|max:40',
            'lastname'      => 'required|max:40',
            'state'         => 'sometimes',
            'zip'           => 'required',
            'city'          => 'required',
            'address'       => 'required',
            'participation' => 'required|numeric|gte:0',
            'email'         => 'required|email|max:40|unique:volunteers,email,' . $volunteer->id,
            'mobile'        => 'required|max:40|unique:volunteers,mobile,' . $volunteer->id,
            'country'       => 'required|in:' . $countries,
            'image'         => [$id ? 'nullable' : 'required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        if ($request->hasFile('image')) {
            try {
                $old = @$volunteer->image;
                $volunteer->image = fileUploader($request->image, getFilePath('volunteer'), getFileSize('volunteer'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $volunteer->firstname    = $request->firstname;
        $volunteer->lastname     = $request->lastname;
        $volunteer->email        = $request->email;
        $volunteer->mobile       = $dialCode . $request->mobile;
        $volunteer->participated = $request->participation;
        $volunteer->country      = $country;
        $volunteer->country_code = $countryCode;
        $volunteer->address      = [
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
            'country' => $country
        ];

        $volunteer->save();
        return back()->withNotify($notify);
    }


    public function singleNotification($id)
    {

        $volunteer = Volunteer::findOrFail($id);
        $general   = gs();
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are currently disabled'];
            return to_route('admin.volunteer.details', $volunteer->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $volunteer->firstname . ' ' . $volunteer->lastname;
        return view('admin.volunteer.notification', compact('pageTitle', 'volunteer'));
    }

    public function sendNotification(Request $request, $id)
    {

        $request->validate([
            'message' => 'required',
            'via'     => 'required|in:email,sms,push',
            'subject' => 'required_if:via,email,push'
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $template = NotificationTemplate::where('act', 'DEFAULT')->where($request->via . '_status', Status::ENABLE)->exists();
        if (!$template) {
            $notify[] = ['warning', 'Default notification template is not enabled'];
            return back()->withNotify($notify);
        }

        $user = Volunteer::findOrFail($id);
        notify($user, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ], [$request->via], pushImage: null);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }
}
