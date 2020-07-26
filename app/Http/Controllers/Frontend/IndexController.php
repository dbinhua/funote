<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\Recommend;

class IndexController extends Controller
{
    const Index_block = [1, 2, 3, 4, 5];
    public function index(Article $article, Recommend $recommend)
    {
//        $blockIds = [1, 2];
//        $recommends = $recommend->getArticleByBlockIds($blockIds);
//        foreach ($recommends as $recommend_slug){
////            $info = $article->getArticleBySlug($recommend_slug);
////            if (!$info) continue;
////            $info['html'] = json_decode($info['html']);
////            $info['cover'] = $this->handleCoverImg($info['cover']);
////            $recommend_data[] = $info;
//        }

//        return view('frontend.index', compact('recommends'));
    }
}
