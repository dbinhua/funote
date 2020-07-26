<?php

namespace App\Admin\Controllers;

use App\Models\Article\Recommend;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RecommendController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '数据推荐';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Recommend());
        $grid->column('id', __('ID'));
        $grid->column('name', __('模块名'));
        $grid->column('max_data_num', __('最大展示数据'));
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
        $show = new Show(Recommend::findOrFail($id));
        $show->field('block_id', __('模块ID'));
        $show->field('article_id', __('文章ID'));
        $show->field('weight', __('权重'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Recommend());
        $form->text('block_id', __('模块ID'));
        $form->text('article_id', __('文章ID'));
        $form->number('weight', __('权重'))->default(0);
        return $form;
    }
}
