<?php

namespace App\Http\Controllers\Unit;

use App\Models\Utype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtypesController extends Controller
{
    public function option(Utype $utype)
    {
        $floor = $utype->judgeFloor($utype->id);
        $data = null;
        switch ($floor) {
            case 1 :
                $data = $utype->g_p_units();
                break;
            case 2 :
                $data = $utype->p_units();
                break;
            case 3 :
                $data = $utype->units();
                break;
        }

        return successJson($data);
    }

    public function searchOption()
    {
        $utypes = Utype::get();
        return successJson($utypes);
    }
}
