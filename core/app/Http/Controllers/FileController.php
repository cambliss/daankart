<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Campaign;

class FileController extends Controller
{
   public function duplicateBlade()
{
    $originalPath = resource_path('views/templates/basic/campaign/details.blade.php');
    $newFileName = 'details_copy.blade.php';
    $newPath = resource_path('views/templates/basic/campaign/' . $newFileName);

    if (File::exists($originalPath)) {
        File::copy($originalPath, $newPath);
        
        $campaign = Campaign::first(); // Ensure a valid ID
        if (!$campaign) {
            return response()->json(['message' => 'No campaign found!'], 404);
        }

        return redirect()->route('show.duplicate.page', ['id' => $campaign->id]);
    } else {
        return response()->json(['message' => 'File not found!'], 404);
    }
}

  public function showDuplicatePage($id)
{
    $campaign = Campaign::find($id);
    if (!$campaign) {
        return abort(404, 'Campaign not found');
    }

    // Define the page title and pass it to the view
    $pageTitle = 'Campaign Details'; 

    return view('templates.basic.campaign.details_copy', compact('campaign', 'pageTitle'));
}
}
