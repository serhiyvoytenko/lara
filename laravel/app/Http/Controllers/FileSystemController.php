<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileSystemController extends Controller
{
    public function listDirectory(Request $request)
    {
        $fileList = Storage::files('/');
        $sizeFile = Storage::size('/text.txt');
        $uploaded = Storage::lastModified('/text.txt');
        $dirList = Storage::directories('/');
        return view('dashboard', [
            'fileList' => $fileList,
            'dirList' => $dirList,
            'sizeFile' => $sizeFile,
            'uploaded' => $uploaded,]);
    }
    //
}
