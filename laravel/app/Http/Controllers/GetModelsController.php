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
        }

        $columns = json_encode($model->getFillable());
//        var_dump($columns,$url);

                return redirect("editfield?name={$url}&fieldModel={$columns}");
    }


}
