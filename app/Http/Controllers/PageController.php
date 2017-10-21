<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class PageController extends Controller
{
    public function about_us(Request $request)
    {
        return view('page/about_us');
    }

    public function membership(Request $request)
    {
        return view('page/membership');
    }

    public function license(Request $request)
    {
        return view('page/license');
    }
   
}