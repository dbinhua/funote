<?php

namespace App\Models\User;

class UserInfo
{
    public $name;
    public $password;
    public $avatar;

    /**
     * @var int 1-男 2-女 0-未知
     */
    public $gender;

    public $email;

    /**
     * @var int 1-正常 2-冻结 3-注销 0-未激活
     */
    public $status;

    /**
     * @var int 1-注册用户 8-超管
     */
    public $rank;
    public $created_at;
    public $updated_at;

    /**
     * @var string 职业
     */
    public $profession;

    /**
     * @var string 星座
     */
    public $constellation;
}
