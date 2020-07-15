<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ThirdUser extends Model
{
    const WEIBO = 1;
    const WECHAT = 2;

    protected $guarded = [];

    /**
     * @param ThirdUserInfo $info
     * @return bool
     */
    public function createOrUpdateThirdUser(ThirdUserInfo $info)
    {
        return $this->updateOrCreate(['uid' => $info->uid, 'type' => $info->type], (array)$info);
    }

    public function getInfo(int $uid, int $type)
    {
        return $this->where(compact('uid', 'type'))->firstOrFail();
    }

    public function getInfoById(int $id)
    {
        return $this->find($id);
    }
}
