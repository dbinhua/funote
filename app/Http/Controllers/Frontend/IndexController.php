<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;

class IndexController extends Controller
{
    public function index(Article $article)
    {
        $recommend_slugs = ['one','er','san'];
        $recommend_data = [];
        foreach ($recommend_slugs as $recommend_slug){
//            $info = $article->getArticleBySlug($recommend_slug);
//            if (!$info) continue;
//            $info['html'] = json_decode($info['html']);
//            $info['cover'] = $this->handleCoverImg($info['cover']);
//            $recommend_data[] = $info;
        }

        return view('frontend.index', compact('recommend_data'));
    }
}
