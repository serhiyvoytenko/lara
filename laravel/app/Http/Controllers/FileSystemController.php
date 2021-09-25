<?php

namespace App\Http\Controllers;

use App\Models\File;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FileSystemController extends Controller
{
    public function listDirectory(Request $request)
    {
        $view['url'] = $request->dir ?? '/';
        $filesName = [];

        if (isset($_GET['dir']) &&
            !empty($_GET['dir']) &&
            $_GET['dir'] !== '//') {
            $url = explode('/', trim($request->dir, '/'));
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

        $arrayDirName = Storage::directories($request->dir ?? '/');
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

        $arrayFilesName = Storage::files($request->dir ?? '/');
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

    public function editField(Request $request): mixed
    {
        if (!$request->name || $request->name === '/') {
            return redirect('dashboard');
        }

        if (session()->get('model') !== null) {
            var_dump(session()->get('model'), request()->headers->get('referer'));exit();
        }
//        var_dump($request);exit();
        $arrayPath = explode('/', $request->name);
        $path = Storage::path(trim($request->name, '/'));
        $guid = xattr_get($path, 'laravel');
        if (!$guid) {
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
        $modelled = substr(strrchr($xAttribute['modelled_type'] ?? '', '\\'), 1) ?? '';
        $file_model = File::find($xAttribute['id'] ?? '');
        $modelled_key = array_fill_keys($file_model?->modelled()->getRelated()->getFillable() ?? [], null);
        if (!empty($modelled_key)) {
            $field_model = $file_model?->modelled()->getRelated()->get(array_keys($modelled_key))->toArray();
        }
        $modelledType = $field_model[0] ?? $modelled_key;

        $field = [
            'shortName' => $shortName,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'comment' => $comments,
            'fullName' => $request->name,
            'guid' => $guid,
            'modelled' => $modelled,
            'model_field' => $modelledType,
        ];

//        $field = array_merge($field, $modelledType);
//        var_dump($field, $modelled_key);        exit();
        return view('editfield', [
            'view' => $field,
        ]);
    }

    public function save(Request $request)
    {
//var_dump($request);exit();
        $oldData = (array)json_decode($request->guid);
        $oldData['title'] = $request->title;
        $oldData['description'] = $request->description;
        $oldData['comment'] = $request->comment;

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
        $url = dirname($oldData['fullName']);

        return redirect("dashboard?dir={$url}");
    }

    public function download(Request $request)
    {
        return Storage::download($request->file);
    }

    public function delete(Request $request)
    {
        $path = Storage::path(trim($request->file, '/'));
        if (Storage::exists($request->file) && !is_dir($path)) {
            $guid = xattr_get($path, 'laravel');
            if ($guid) {
                DB::table('files')->where('guid', $guid)->delete();
            }
            Storage::delete($request->file);
        } elseif (is_dir($path)) {
            $allDirs = Storage::allDirectories($request->file);
            $allFiles = Storage::allFiles($request->file);
            $pathShort = Storage::path('');
            foreach ($allDirs as $dir) {
                $guid = xattr_get($pathShort . $dir, 'laravel');
                if ($guid) {
                    DB::table('files')->where('guid', $guid)->delete();
                }
            }
            foreach ($allFiles as $file) {
                $guid = xattr_get($pathShort . $file, 'laravel');
                if ($guid) {
                    DB::table('files')->where('guid', $guid)->delete();
                }
            }
            Storage::deleteDirectory($request->file);
        }

        $url = dirname($request->file);
        return redirect("dashboard?dir={$url}");
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'files' => 'required',
            'files.*' => 'mimes:doc,pdf,docx,zip,png,jpeg,xls'
        ]);

        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
//                Storage::putFileAs($request->dir, $name, $name);
                $file->move(Storage::path('') . $request->dir, $name);
            }
        }
        $url = $request->dir;
        return redirect("dashboard?dir={$url}");
    }

    public function create(Request $request)
    {
        Storage::makeDirectory($request->dir . $request->directory_name);

        $url = $request->dir;
        return redirect("dashboard?dir={$url}");
    }
}
