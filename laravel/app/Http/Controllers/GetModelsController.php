<?php

namespace App\Http\Controllers;

use App\Models\Act;
use App\Models\Certificate;
use App\Models\Contract;
use App\Models\Estimate;
use App\Models\Message;
use App\Models\Report;
use App\Models\Schema;
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
                $model = new Schema();
                break;
            case 'reports':
                $model = new Report();
                break;
            case 'acts':
                $model = new Act();
                break;
            case 'certificates':
                $model = new Certificate();
                break;
            case 'estimates':
                $model = new Estimate();
                break;
            case 'contracts':
                $model = new Contract();
                break;
            case 'requests':
                $model = new \App\Models\Request();
                break;
            default:
                $model = null;

        }
        if ($model) {
            $fields = array_fill_keys($model->getFillable(), null);
            $modelled = $model::class;
        } else {
            $fields = [];
            $modelled = '';
        }

        return redirect("editfield?name={$url}")->with([
            'model' => $fields,
            'modelled' => $modelled,
        ]);
    }


}
