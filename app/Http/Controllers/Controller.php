<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\ApiResponse;
use App\Http\Controllers\Helpers\ImageTool;
use App\Http\Controllers\Helpers\ObjectTool;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponse, ObjectTool, ImageTool;

    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            $this->user && $this->user->avatar = $this->handleAvatarImg($this->user->avatar);
            View::share('userInfo', $this->user);
            return $next($request);
        });
    }
}
