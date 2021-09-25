<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class GetModelsController extends Controller
{
    public function getmodels(Request $request)
    {
        $url = $request->dir;

        switch ($request->page) {
            case 'messages':
                $model = new Message();
                break;
            case 'schemas':
                $model = '';
                break;
            case 'reports':
                $model = '1';
                break;
            case 'acts':
                $model = '2';
                break;
            case 'certificates':
                $model = '3';
                break;
            case 'estimates':
                $model = '4';
                break;
            case 'contracts':
                $model = '5';
                break;
            case 'requests':
                $model = '6';
                break;
        }

    $fields = '';
        $columns = $model->getFillable();
        foreach ($columns as $column) {
            $fields .= '&' . $column;
        }
//        var_dump($columns,$url, $fields);

                return redirect("editfield?name={$url}{$fields}");
    }


}
