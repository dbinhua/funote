<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ThirdUser extends Model
{
    const WEIBO = 1;
    const WECHAT = 2;

    /**
     * @param ThirdUserInfo $info
     * @return bool
     */
    public function createOrUpdateThirdUser(ThirdUserInfo $info)
    {
        $real_info = $this->getInfo($info->uid, $info->type);

        foreach ($info as $key => $val){
            if ($real_info){
                $real_info->{$key} = $val;
            }else{
                $this->{$key} = $val;
            }
        }
        return $real_info ? $real_info->save() : $this->save();
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
