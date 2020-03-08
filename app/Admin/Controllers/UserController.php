<?php

namespace App\Admin\Controllers;

use App\Models\User\Constellations;
use App\Models\User\Professions;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('ID'))->width(50);
        $grid->column('avatar', __('头像'))->image('', 25, 25)->width(50);
        $grid->column('name', __('昵称'))->width(150);
        $grid->column('email', __('邮箱'))->width(150);
        $grid->column('status', __('状态'))->using(['1' => '正常'])->width(100);
        $grid->column('gender', __('性别'))->using(['1' => '男', '2' => '女', '0' => '-'])->width(100);
        $grid->column('profession', __('职业'))->using(Professions::MAP)->width(100);
        $grid->column('constellation', __('星座'))->using(Constellations::MAP)->width(100);
        $grid->column('created_at', __('注册时间'))->sortable();

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('avatar', __('Avatar'));
        $show->field('status', __('Status'));
        $show->field('gender', __('Gender'));
        $show->field('rank', __('Rank'));
        $show->field('profession', __('Profession'));
        $show->field('constellation', __('Constellation'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('remember_token', __('Remember token'));
        $form->image('avatar', __('Avatar'));
        $form->switch('status', __('Status'))->default(1);
        $form->switch('gender', __('Gender'));
        $form->switch('rank', __('Rank'))->default(1);
        $form->text('profession', __('Profession'));
        $form->text('constellation', __('Constellation'));

        return $form;
    }
}
