<?php

namespace App\Admin\Controllers;

use App\Models\Article\Article;
use App\Models\User\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

//        $grid->column('id', __('Id'));
        $grid->column('cate_id', __('分类'));
        $grid->column('slug', __('Slug'));
        $grid->column('title', __('标题'));
//        $grid->column('subtitle', __('Subtitle'));
//        $grid->column('cover', __('Cover'));
//        $grid->column('intro', __('Intro'));
        $grid->column('top', __('置顶'))->display(function ($top) {return $top ? '是' : '否';});
//        $grid->column('content', __('Content'));
//        $grid->column('html', __('Html'));
//        $grid->column('view_count', __('View count'));
//        $grid->column('praise_count', __('Praise count'));
//        $grid->column('favorite_count', __('Favorite count'));
        $grid->column('attr', __('属性'));
        $grid->column('user_id', __('作者'))->display(function($userId) {return User::findOrFail($userId)->name;});
        $grid->column('publish_at', __('发布时间'));
//        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('更新时间'));
//        $grid->column('deleted_at', __('Deleted at'));

        $grid->disableCreateButton();
        $grid->disableExport();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cate_id', __('Cate id'));
        $show->field('slug', __('Slug'));
        $show->field('title', __('Title'));
        $show->field('subtitle', __('Subtitle'));
        $show->field('cover', __('Cover'));
        $show->field('intro', __('Intro'));
        $show->field('top', __('Top'));
        $show->field('content', __('Content'));
        $show->field('html', __('Html'));
        $show->field('view_count', __('View count'));
        $show->field('praise_count', __('Praise count'));
        $show->field('favorite_count', __('Favorite count'));
        $show->field('attr', __('Attr'));
        $show->field('user_id', __('User id'));
        $show->field('publish_at', __('Publish at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->switch('cate_id', __('Cate id'));
        $form->text('slug', __('Slug'));
        $form->text('title', __('Title'));
        $form->text('subtitle', __('Subtitle'));
        $form->image('cover', __('Cover'));
        $form->text('intro', __('Intro'));
        $form->switch('top', __('Top'));
        $form->textarea('content', __('Content'));
        $form->textarea('html', __('Html'));
        $form->number('view_count', __('View count'));
        $form->number('praise_count', __('Praise count'));
        $form->number('favorite_count', __('Favorite count'));
        $form->text('attr', __('Attr'))->default('1');
        $form->number('user_id', __('User id'));
        $form->datetime('publish_at', __('Publish at'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
