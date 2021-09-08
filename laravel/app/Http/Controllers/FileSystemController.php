<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class FileSystemController extends Controller
{
    public function listDirectory(Request $request)
    {
//        $view['url'] = $_GET['dir']??'/';
//        $view['uuid'] = Str::orderedUuid()->toString();
//        $view['files'] = Storage::files($_GET['dir']??'/');
//        $view['sizes'] = Storage::size('/text.txt');
//        $view['dataUpload'] = Storage::lastModified('/text.txt');
//        $view['directory'] = Storage::directories($_GET['dir']??'/');
        $filesName = [];

        if (isset($_GET['dir']) &&
            !empty($_GET['dir']) &&
            $_GET['dir'] !== '//') {
            $url = explode('/', trim($_GET['dir'], '/'));
            array_pop($url);
            if (empty($url)) {
                $url = '/';
                $modified = null;
            } else {
                $url = implode('/', $url);
                $modified = Storage::lastModified($url);
                $modified = date('Y-m-d H:i:s', $modified);
            }

            $filesName['..'] = [
                'isDir' => true,
                'fullName' => trim($url, '/'),
                'shortName' => '..',
                'modified' => $modified,
            ];

        }

        $arrayDirName = Storage::directories($_GET['dir'] ?? '/');
        foreach ($arrayDirName as $dirName) {
            $view = explode('/', $dirName);
            $shortName = array_pop($view);
            $filesName [$shortName] = [
                'isDir' => true,
                'fullName' => $dirName,
                'shortName' => $shortName,
                'modified' => date('Y-m-d H:i:s', Storage::lastModified($dirName)),
            ];
        }

        $arrayFilesName = Storage::files($_GET['dir'] ?? '/');
        foreach ($arrayFilesName as $fileName) {
            $view = explode('/', $fileName);
            $shortName = array_pop($view);
            $filesName [$shortName] = [
                'fullName' => $fileName,
                'shortName' => $shortName,
                'modified' => date('Y-m-d H:i:s', Storage::lastModified($fileName)),
                'size' => Storage::size($fileName),
            ];
        }

        return view('dashboard', [
            'view' => $filesName,
        ]);
    }
    //
}
