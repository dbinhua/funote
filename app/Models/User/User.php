<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QCod\ImageUp\Exceptions\InvalidUploadFieldException;
use QCod\ImageUp\HasImageUploads;

class User extends Model
{
    use HasImageUploads;

    protected $user;

    public function __construct(array $attributes = [])
    {
        $this->user = Auth::user();
        parent::__construct($attributes);
    }

    protected function avatarUploadFilePath($file) {
        return md5('avatar-'. $this->user['id']).'.jpg';
    }

    /**
     * @param UserInfo $info
     * @return int
     */
    public function createUserReturnId(UserInfo $info):int
    {
        foreach ($info as $key => $val){
            $this->{$key} = $val;
        }
        $this->save();
        return $this->id;
    }

    public function getInfoById(int $user_id)
    {
        return $this->whereId($user_id)->first();
    }

    public function updateInfo(array $data)
    {
        $this->user['name'] = $data['name'];
        $this->user['gender'] = $data['gender'];
        $this->user['profession'] = $data['profession'];
        $this->user['constellation'] = $data['constellation'];

        return $this->user->save();
    }

    public function uploadImg($file)
    {
        try {
            $this->user->uploadImage($file, 'avatar');
        } catch (InvalidUploadFieldException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }

        $res = $this->user->save();
        return $res;
    }
}
