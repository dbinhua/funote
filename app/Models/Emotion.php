<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{
    public function getAll()
    {
        return $this->select()->get();
    }
}
