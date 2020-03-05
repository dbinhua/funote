<?php

namespace App\Models;

use QCod\ImageUp\HasImageUploads;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasImageUploads;

    protected static $imageFields = [
        'cover' => [
            'width' => 300,
            'height' => 175,
            'crop' => true,
            'placeholder' => '/images/default_cover.png',
            'rules' => 'image|max:2000',
            'path' => 'uploads/article'
        ]
    ];

    protected function coverUploadFilePath($file) {
        return 'cover-'. $this->slug .'.jpg';
    }

    const Publish = 1;   //已发布
    const Draft = 2;     //草稿

    protected $article_id;

    public function createArticle(array $article)
    {
        foreach ($article as $key => $item){
            $this->{$key} = $item;
        }

        $res = $this->save();
        $this->article_id = $this->id;

        return $res;
    }

    /**
     * @param string $slug
     * @param string $status
     * @return mixed
     */
    public function getArticleBySlug(string $slug, string $status = self::Publish)
    {
        $timestamp = date('Y-m-d H:i:s', time());

        if ($status == self::Publish){
            $article = $this->where([
                ['slug', '=', $slug],
                ['publish_at', '<=', $timestamp]
            ])->first();
        }elseif ($status == self::Draft){
            $article = $this->where([
                ['slug', '=', $slug],
                ['publish_at', '=', null]
            ])->first();
        }
        return $article;
    }
}
