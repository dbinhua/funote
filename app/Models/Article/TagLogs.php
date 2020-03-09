<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class TagLogs extends Model
{
    protected $fillable = ['tag_id', 'article_id'];

    const LIMIT = 10;

    public function createLogs(int $tag_id, int $article_id)
    {
        return $this->firstOrCreate(compact('tag_id', 'article_id'));
    }

    /**
     * @param int $tag_id
     * @param int $article_id
     * @return mixed
     */
    public function getLogs(int $tag_id = 0 ,int $article_id = 0)
    {
        ($tag_id && $article_id) && $where = compact('tag_id', 'article_id');
        (!$tag_id && $article_id) && $where = compact('article_id');
        ($tag_id && !$article_id) && $where = compact('tag_id');
        (!$tag_id && !$article_id) && $where = [];

        $logs = $this->where($where)->limit(self::LIMIT)->get();
        return $logs;
    }
}
