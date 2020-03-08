<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class TagLogs extends Model
{
    const LIMIT = 10;

    public function createLogs(int $articleId, int $tagId)
    {
        $this->tag_id = $tagId;
        $this->article_id = $articleId;
        return $this->save();
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
