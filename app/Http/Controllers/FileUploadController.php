<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,pdf|max:2048',
        ]);
    
        $file = $request->file('file');
        $path = $file->storeAs('uploads', $file->getClientOriginalName(),'public');

        return "File uploaded successfully!";
    }
    
    public function show($filename)
    {
        $url = Storage::url("uploads/{$filename}");
    
        return view('file.show', ['url' => $url]);
    }
}
