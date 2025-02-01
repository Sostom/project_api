<?php

namespace App\Http\Controllers;
use App\Models\CautionType;

use Illuminate\Http\Request;

class CautionTypeController extends Controller
{
    public function index()
    {
        $cautionTypes = CautionType::all();
        return response()->json($cautionTypes);
    }

}
