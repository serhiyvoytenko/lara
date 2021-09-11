<?php

namespace App\Http\Controllers;
use App\Models\File;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FileSystemController extends Controller
{
    public function listDirectory()
    {
        $view['url'] = $_GET['dir'] ?? '/';
        $filesName = [];

        if (isset($_GET['dir']) &&
            !empty($_GET['dir']) &&
            $_GET['dir'] !== '//') {
            $url = explode('/', trim($_GET['dir'], '/'));
            array_pop($url);
            if (empty($url)) {
                $url = '/';
            } else {
                $url = implode('/', $url);
            }

            $filesName['..'] = [
                'isDir' => true,
                'fullName' => trim($url, '/'),
                'shortName' => '[Parent] ..',
            ];

        }

        $arrayDirName = Storage::directories($_GET['dir'] ?? '/');
        foreach ($arrayDirName as $dirName) {
            $view = explode('/', $dirName);
            $path = Storage::path($dirName);
            $guid = xattr_get($path, 'laravel');
            $xAttribute = (array)DB::table('files')->where('guid', $guid)->first();
            $title = $xAttribute['title'] ?? false;
            $description = $xAttribute['description'] ?? false;
            $comments = $xAttribute['comments'] ?? false;
            $category = $xAttribute['category'] ?? false;

            $shortName = array_pop($view);
            $filesName [$shortName] = [
                'isDir' => true,
                'fullName' => $dirName,
                'shortName' => $shortName,
                'modified' => date('Y-m-d H:i:s', Storage::lastModified($dirName)),
                'title' => $title,
                'description' => $description,
                'category' => $category,
                'comment' => $comments,
            ];
        }

        $arrayFilesName = Storage::files($_GET['dir'] ?? '/');
        foreach ($arrayFilesName as $fileName) {
            $view = explode('/', $fileName);
            $path = Storage::path($fileName);
            $guid = xattr_get($path, 'laravel');
            $xAttribute = (array)DB::table('files')->where('guid', $guid)->first();
            $title = $xAttribute['title'] ?? false;
            $description = $xAttribute['description'] ?? false;
            $comments = $xAttribute['comments'] ?? false;
            $category = $xAttribute['category'] ?? false;
            $shortName = array_pop($view);
            $filesName [$shortName] = [
                'fullName' => $fileName,
                'shortName' => $shortName,
                'modified' => date('Y-m-d H:i:s', Storage::lastModified($fileName)),
                'size' => Storage::size($fileName),
                'title' => $title,
                'description' => $description,
                'category' => $category,
                'comment' => $comments,
            ];
        }

        return view('dashboard', [
            'view' => $filesName,
        ]);
    }

    public function editField(): mixed
    {
        if (empty($_GET['name'])) {
            return redirect('dashboard');
        }
        $arrayPath = explode('/', $_GET['name']);
        $path = Storage::path(trim($_GET['name'], '/'));
        $guid = xattr_get($path, 'laravel');
        if(!$guid){
            $guid = Str::orderedUuid()->toString();
            xattr_set($path, 'laravel', $guid);
        }
        $type = mime_content_type($path);
        $shortName = array_pop($arrayPath);
        $xAttribute = (array)DB::table('files')->where('guid', $guid)->first();
        $title = $xAttribute['title'] ?? false;
        $description = $xAttribute['description'] ?? false;
        $comments = $xAttribute['comments'] ?? false;
        $category = $xAttribute['category'] ?? false;

        $field = [
            'shortName' => $shortName,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'comment' => $comments,
            'fullName' => $_GET['name'],
            'guid' => $guid,
        ];

        return view('editfield', [
            'view' => $field,
        ]);
    }

    public function save(Request $request){

        $oldData = (array)json_decode($_POST['guid']);
        $oldData['title'] = $_POST['title'];
        $oldData['description'] = $_POST['description'];
        $oldData['comment'] = $_POST['comment'];

        $file = File::get()->where('guid', $oldData['guid'])->first();
        if (!isset($file)) {
            $file = new File();
        }
            $file->title = $_POST['title'];
            $file->guid = $oldData['guid'];
            $file->path = $oldData['fullName'];
            $file->description = $_POST['description'];
            $file->category = 1;
            $file->comments = $_POST['comment'];
            $file->shortname = $oldData['shortName'];
            $file->fullname = $oldData['fullName'];
            $file->save();
            $url = $oldData['fullName'].'/..';

        return redirect("dashboard?dir={$url}");
    }
}
