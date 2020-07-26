<?php

namespace App\Admin\Controllers;

use App\Models\Article\DataBlock;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DataBlockController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '数据版块';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DataBlock());
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
        $show = new Show(DataBlock::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('name', __('模块名'));
        $show->field('max_data_num', __('最大展示数据'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DataBlock());
        $form->text('name', __('模块名'));
        $form->text('max_data_num', __('最大展示数据'));
        return $form;
    }
}
