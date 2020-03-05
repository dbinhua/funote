<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\UserRank;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Parsedown;

class ArticleController extends Controller
{
    public function writingPage()
    {
        if ($this->user->rank != UserRank::SUPERVISOR){
            return redirect()->route('index');
        }
        return view('frontend.article.create');
    }

    public function create(Request $request, Parsedown $parsedown, Article $article)
    {
        if ($this->user->rank != UserRank::SUPERVISOR){
            return redirect()->route('index');
        }

        $data = $request->except('_token');
        $data['html'] = json_encode($parsedown->text($data['content']));
        $data['content'] = json_encode($data['content']);
        $data['top'] = isset($data['top']) ? 1 : 0;
        $data['user_id'] = strval(Auth::user()->id);

        //处理tags
        $tags = $data['tags'];
        unset($data['tags']);

        if ($data['act'] == 'pub'){
            $data['publish_at'] = date('Y-m-d H:i:s', time());
        }

        unset($data['act']);
        unset($data['cover']);

        $res = $article->createArticle($data);

        return redirect()->route('index');
    }

    public function detail(User $user, Article $article, $slug)
    {
        $info = $article->getArticleBySlug($slug);
        if ($info){
            $info['html'] = json_decode($info['html']);

            $user_info = $user->getInfoById($info['user_id']);
            $user_info['avatar'] = $this->handleAvatarImg($user_info['avatar']);
            return view('frontend.article.detail', compact('info','user_info'));
        }
    }

    public function checkSlug(Request $request, Article $article)
    {
        $req = $request->all();
        $info = $article->getArticleBySlug($req['slug']);
        if (!$info || ($info && $info['id'] == $req['id'])){
            return $this->success(['result' => 0]);
        }else{
            return $this->success(['result' => 1]);
        }
    }
}
