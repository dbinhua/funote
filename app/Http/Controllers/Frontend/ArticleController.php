<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article\Tag;
use App\Models\Article\TagInfo;
use App\Models\Article\TagLogs;
use App\Models\User\User;
use App\Models\User\UserRank;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use Parsedown;

class ArticleController extends Controller
{
    public function getCreate()
    {
        if ($this->user->rank != UserRank::SUPERVISOR){
            return redirect()->route('index');
        }

        return view('frontend.article.create');
    }

    public function postCreate(Request $request, Parsedown $parsedown, Article $article)
    {
        if ($this->user->rank != UserRank::SUPERVISOR){
            return redirect()->route('index');
        }

        $data = $request->except('_token');
        $data['html'] = json_encode($parsedown->text($data['content']));
        $data['content'] = json_encode($data['content']);
        $data['top'] = isset($data['top']) ? 1 : 0;
        $data['user_id'] = $this->user->id;

        if ($data['act'] == 'pub'){
            $data['publish_at'] = date('Y-m-d H:i:s', time());
        }

        $tags = explode(',', $data['tags']);
        unset($data['act'], $data['cover'], $data['tags']);

        $article_id = $article->createArticle($data);

        //处理tags
        if ($article_id){
            $this->handleArticleTags($article_id, $tags);
        }

        return redirect()->route('index');
    }

    public function detail(User $user, Article $article, $slug)
    {
        $tagLogsModel = new TagLogs();
        $tagModel = new Tag();

        $info = $article->getArticleBySlug($slug);
        if ($info){
            $info['html'] = json_decode($info['html']);
            $user_info = $user->getInfoById($info['user_id']);
            $user_info['avatar'] = $this->handleAvatarImg($user_info['avatar']);

            $tagLogs = $tagLogsModel->getLogs(0, $info['id']);
            $tags = [];
            foreach ($tagLogs as $tagLog){
                $tagInfo = $tagModel->getTagInfo($tagLog->tag_id);
                $tags[] = $tagInfo;
            }
        }
        return view('frontend.article.detail', compact('info','user_info', 'tags'));
    }

    public function handleArticleTags(int $articleId, array $tags)
    {
        $tagModel = new Tag();
        $tagLogModel = new TagLogs();

        foreach ($tags as $tag){
            if (!$tag) continue;
            //检查标签是否存在
            $info = $tagModel->getTagsBySlug($tag);
            $tag_id = $info->id ?? null;
            if (!$tag_id){
                $newTag = new TagInfo($tag, $tag, $this->user->id);
                $tag_id = $tagModel->createTag($newTag);
            }

            //给文章打标签
            $tagLogModel->createLogs($tag_id, $articleId);
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

    public function searchTagsByName(Tag $tag, string $tagName)
    {
        $data = $tag->getTagsByName($tagName, true);
        $res = [];
        foreach ($data as $item){
            $tagInfo = new TagInfo($item->name, $item->slug);
            $res[] = $this->filterObjectNullAttr($tagInfo);
        }
        return $this->success($res);
    }
}
