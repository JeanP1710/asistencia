<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    public function todos(){
        $establecimientos = Sede::get();
        return $establecimientos;
    }
    public function show(Request $request)
    {
        $menu = Sede::where('id', $request->id)->first();
        return $menu;
    }
}
