<?php

namespace App\Models\Article;

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
    const PAGE = 1;
    const PAGE_SIZE = 10;

    protected $article_id;

    public function createArticle(array $article)
    {
        foreach ($article as $key => $item){
            $this->{$key} = $item;
        }

        $this->save();
        $this->article_id = $this->id;

        return $this->getId();
    }

    /**
     * @param int $articleId
     * @param array $articleData
     * @return mixed
     */
    public function updateArticle(int $articleId, array $articleData)
    {
        $article = $this->find($articleId);
        foreach ($articleData as $key => $item){
            $article->{$key} = $item;
        }
        return $article->save();
    }

    public function getId()
    {
        return $this->article_id;
    }

    /**
     * @param string $slug
     * @param string $status
     * @return mixed
     */
    public function getArticleBySlug(string $slug, string $status = self::Publish)
    {
        $timestamp = date('Y-m-d H:i:s');

        if ($status == self::Publish){
            $article = $this->where([
                ['slug', '=', $slug],
                ['publish_at', '<=', $timestamp]
            ])->firstOrFail();
        }elseif ($status == self::Draft){
            $article = $this->where([
                ['slug', '=', $slug],
                ['publish_at', '=', null]
            ])->firstOrFail();
        }
        return $article;
    }

    public function getArticleByIds(array $articleIds, string $status = self::Publish)
    {
        $timestamp = date('Y-m-d H:i:s');

        if ($status == self::Publish){
            $articles = $this->where([
                ['publish_at', '<=', $timestamp]
            ])->whereIn('id', $articleIds)->limit(5)->get();
        }elseif ($status == self::Draft){
            $articles = $this->where([
                ['publish_at', '=', null]
            ])->whereIn('id', $articleIds)->limit(5)->get();
        }
        return $articles;
    }

    public function getArticleInfo(int $articleId, string $status = self::Publish)
    {
        $timestamp = date('Y-m-d H:i:s');

        if ($status == self::Publish){
            $articles = $this->where([
                ['publish_at', '<=', $timestamp]
            ])->where('id', $articleId)->first();
        }elseif ($status == self::Draft){
            $articles = $this->where([
                ['publish_at', '=', null]
            ])->where('id', $articleId)->first();
        }
        return $articles;
    }

    public function getSearchCount(array $filter = [])
    {
        $bookFilter = [];
        foreach ($filter as $key => $val){
            if ($val === null) continue;
            $bookFilter[] = [$key, $val];
        }
        return $this->where($bookFilter)->count();
    }

    public function searchBooks(array $filter = [], int $page = self::PAGE, int $pageSize = self::PAGE_SIZE)
    {
        $offset = ($page - 1) * $pageSize;

        $bookFilter = [];
        foreach ($filter as $key => $val){
            if ($val === null) continue;
            $bookFilter[] = [$key, $val];
        }
        return $this->where($bookFilter)->orderBy('created_at', 'desc')->offset($offset)->limit($pageSize)->get();
    }
}
