<?php

namespace App\Models\User;

class ThirdUserInfo
{
    public $uid;
    public $nickname;

    /**
     * @var int 三方平台 1-微博
     */
    public $type;

    public $avatar;

    public $avatar_large;
    /**
     * @var int 1-男 2-女 0-未知
     */
    public $gender;

    /**
     * @var int 绑定的用户ID
     */
    public $bind_id;

    public $created_at;
    public $updated_at;
    public $access_token;
}
