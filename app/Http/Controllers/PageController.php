<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function book3D(Request $request)
    {

        return view('3d.index');
    }

    public function wowbook(Request $request)
    {

        return view('wowbook.index');
    }
}
