<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class FileUploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);
        $file = $request->file('file');
        $path = fileUploader($file, getFilePath('campaign'));
        $url = asset('assets/images/campaign/' . $path);
        return response()->json(['path' => $url]);
    }
}