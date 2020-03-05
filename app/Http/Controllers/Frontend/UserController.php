<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $user,int $id)
    {
        $user_info = $user->getInfoById($id);
        $user_info['avatar'] = $this->handleAvatarImg($user_info['avatar']);
        return view('frontend.user.index', compact('user_info'));
    }

    public function edit()
    {
        return view('frontend.user.edit');
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
