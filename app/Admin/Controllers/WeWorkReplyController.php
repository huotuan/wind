<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\SendMessage;
use App\Admin\Repositories\WeWorkReply;
use App\Models\WeWork\WeWorkUser;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class WeWorkReplyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WeWorkReply(['user:id,name']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user.name', '成员');
            $grid->column('title');
            $grid->column('digest')->implode('--');
            $grid->column('status')->switch();
            $grid->column('need_alarm')->switch();
            $grid->column('created_at')->short_datetime();
            $grid->column('updated_at')->short_datetime()->sortable();

            $grid->disableRowSelector();
            $grid->perPages([20, 50, 100]);
            $grid->model()->with('user:id,name')->orderBy('id', 'desc');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('digest');
                $filter->where('user', function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '昵称/手机');
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append(new SendMessage());
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new WeWorkReply(), function (Show $show) {
            $show->field('id');
            $show->field('corp_id');
            $show->field('wechat_user_id');
            $show->field('title');
            $show->field('content');
            $show->field('status');
            $show->field('need_alarm');
            $show->field('recall_time');
            $show->field('interval_time');
            $show->field('url');
            $show->field('destroy_at');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WeWorkReply(), function (Form $form) {
            $form->display('id');
            $form->select('wework_user_id', '成员')->options(WeWorkUser::query()->activated()->selected()->pluck('name', 'id'));
            $form->text('title')->required();
            $form->list('digest')->required();
            $form->textarea('content')->required();
            $form->text('url')->default('#');

            $form->switch('status')->default(1);
            $form->switch('need_alarm');
            $form->number('recall_time')->default(0)->help('多久后撤回，0 未不撤回（秒')->max(86400);
            $form->number('interval_time')->default(0)->help('消息间隔，0 没有间隔（小时）')->max(120);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
