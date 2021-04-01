<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class DevLogController extends Controller
{
    public function index(string $module)
    {
        return view('frontend.log.index');
    }
}
