<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasoudController extends Controller
{
    public function index()
    {
        return view('blog::index');
    }
}
