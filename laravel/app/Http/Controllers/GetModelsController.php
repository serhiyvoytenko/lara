<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Message;
use Illuminate\Http\Request;

class GetModelsController extends Controller
{
    public function getmodels(Request $request)
    {
        $url = $request->dir;
//var_dump($request);exit();
        switch ($request->page) {
            case 'messages':
                $model = new Message();
                break;
            case 'schemas':
                $model = 0;
                break;
            case 'reports':
                $model = 1;
                break;
            case 'acts':
                $model = 2;
                break;
            case 'certificates':
                $model = 3;
                break;
            case 'estimates':
                $model = 4;
                break;
            case 'contracts':
                $model = new Contract();
                break;
            case 'requests':
                $model = 5;
                break;
//            case '#':
//                $model = '';
//                break;
            default:
                $model = null;

        }
        if ($model) {
            $fields['fields'] = $model->getFillable();
            $fields['modelled'] = $request->page;
        } else {
            $fields = null;
        }
//        $fields = json_encode($fields);
//        var_dump($fields);       exit();

        return redirect("editfield?name={$url}")->with('model', $fields);
    }


}
