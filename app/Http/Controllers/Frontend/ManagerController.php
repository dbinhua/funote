<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\UserRank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    public function __construct()
    {
        dd($this->gt());
    }

    public function gt()
    {
        dd($this->user);
        return $this->user;
    }

    public function index()
    {
//        echo $this->user->id;
//        $r = new User();
//        $user_info = $r->getInfoById(Auth::user()->id);
//        dd($this->user);
//        $user_info['avatar'] = $this->handleAvatarImg($user_info['avatar']);
//        return view('frontend.manager.index');
    }

    public function edit(User $user)
    {
        $user_info = $user->getInfoById(Auth::user()->id);
        $user_info['avatar'] = $this->handleAvatarImg($user_info['avatar']);
        return view('frontend.user.edit', compact('user_info'));
    }

    public function update(Request $request, User $user)
    {
        $req = $request->only(['name', 'gender', 'profession', 'constellation']);
        $res = $user->updateInfo($req);

        return $this->success(['result' => $res]);
    }

    public function uploadImg(Request $request, User $user)
    {
        $file = $request->file('avatar');
        $res = $user->uploadImg($file);
        return $this->success(['result' => $res]);
    }
}
