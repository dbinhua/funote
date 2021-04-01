<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\PageHelper;
use App\Models\Article\Tag;
use App\Models\Article\TagInfo;
use App\Models\Article\TagLogs;
use App\Models\Tool\Timer;
use App\Models\User\User;
use App\Models\User\UserRank;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use Parsedown;

class ArticleController extends Controller
{
    const LIST_STYLE = [
        1 => ['tipColor' => 'orange', 'statusText' => '原创'],
        2 => ['tipColor' => 'blue', 'statusText' => '转载']
    ];

    public function getCreate()
    {
        if ($this->user->rank != UserRank::SUPERVISOR){
            return redirect()->route('index');
        }
        $action = 'create';
        return view('frontend.article.create', compact('action'));
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

        if ($data['act'] === 'pub'){
            $data['publish_at'] = date('Y-m-d H:i:s');
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

    public function manage(Request $request, Article $article)
    {
        if ($this->user->rank != UserRank::SUPERVISOR){
            return redirect()->route('index');
        }

        //获取分页数据
        $currentPage = $request->query('page', 1);
        $count = $article->getSearchCount(['user_id' => $request->user()->id]);

        $totalPage = ceil($count / Article::PAGE_SIZE);
        $currentPage > $totalPage && $currentPage = $totalPage;
        $pageOptions = PageHelper::getPageData($currentPage, $count);

        //获取文章数据
        $articles = $article->searchBooks(['user_id' => $request->user()->id], $currentPage);
        foreach ($articles as $oneArticle){
            $oneArticle->cover = $this->handleCoverImg($oneArticle->cover ?? '');
            $oneArticle->tipColor = self::LIST_STYLE[$oneArticle->attr]['tipColor'];
            $oneArticle->statusText = self::LIST_STYLE[$oneArticle->attr]['statusText'];
        }
        $action = 'manage';
        return view('frontend.article.manage', compact('articles', 'count', 'pageOptions', 'action'));
    }

    public function detail(User $user, Article $article, string $slug)
    {
        $time = new Timer();
        $tagLogsModel = new TagLogs();
        $tagModel = new Tag();

        $info = $article->getArticleBySlug($slug);
        if ($info){
            $info->html = json_decode($info->html);
            $info->tranTime = $time->tranTime($info->created_at);
            $info->cover = $this->handleCoverImg($info->cover);
            $user_info = $user->getInfoById($info->user_id);
            $user_info->avatar = $this->handleAvatarImg($user_info->avatar);

            $tagLogs = $tagLogsModel->getLogs(0, $info->id);
            $tags = $articleIds = [];
            foreach ($tagLogs as $tagLog){
                $tagInfo = $tagModel->getTagInfo($tagLog->tag_id);
                $tags[] = $tagInfo;
                $recom_tagLogs = $tagLogsModel->getLogs($tagLog->tag_id);
                foreach ($recom_tagLogs as $log){
                    $articleIds[] = $log->article_id;
                }
            }
            $recommend_articles = $article->getArticleByIds($articleIds);
        }
        return view('frontend.article.detail', compact('info','user_info', 'tags', 'recommend_articles'));
    }

    public function updatePage(User $user, Article $article, string $slug)
    {
        $time = new Timer();
        $tagLogsModel = new TagLogs();
        $tagModel = new Tag();

        $info = $article->getArticleBySlug($slug);
        if ($info){
            $info->content = json_decode($info->content);
            $info->tranTime = $time->tranTime($info->created_at);
            $info->cover = $this->handleCoverImg($info->cover ?? '');
            $user_info = $user->getInfoById($info->user_id);
            $user_info->avatar = $this->handleAvatarImg($user_info->avatar);

            $tagLogs = $tagLogsModel->getLogs(0, $info->id);
            $tags = $articleIds = [];
            foreach ($tagLogs as $tagLog){
                $tagInfo = $tagModel->getTagInfo($tagLog->tag_id);
                $tags[] = $tagInfo;
                $recom_tagLogs = $tagLogsModel->getLogs($tagLog->tag_id);
                foreach ($recom_tagLogs as $log){
                    $articleIds[] = $log->article_id;
                }
            }
            $tags = implode(',', array_column($tags, 'name'));
            $recommend_articles = $article->getArticleByIds($articleIds);
        }
        $action = 'update';
        return view('frontend.article.update', compact('info','user_info', 'tags', 'recommend_articles', 'action'));
    }

    public function postUpdate(Request $request, Parsedown $parsedown, Article $article)
    {
        if ($this->user->rank != UserRank::SUPERVISOR){
            return redirect()->route('index');
        }

        $data = $request->except('_token');
        $data['html'] = json_encode($parsedown->text($data['content']));
        $data['content'] = json_encode($data['content']);
        $data['top'] = isset($data['top']) ? 1 : 0;
        $data['user_id'] = $this->user->id;

        if ($data['act'] === 'pub'){
            $data['publish_at'] = date('Y-m-d H:i:s');
        }

        $tags = explode(',', $data['tags']);
        unset($data['act'], $data['cover'], $data['tags']);

        $result = $article->updateArticle($data['article_id'], $data);
        if ($result){
            $this->handleArticleTags($data['article_id'], $tags);
        }

        return redirect()->route('index');
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
