<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    public function getArticleByBlockIds(array $blockIds)
    {
        return $this->whereIn('block_id', $blockIds)->orderBy('weight', 'desc')->get();
    }
}
