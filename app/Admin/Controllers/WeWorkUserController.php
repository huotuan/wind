<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use App\Models\WeWork\WeWorkReply;
use App\Admin\Repositories\WeWorkUser;
use Dcat\Admin\Grid\Tools\ActionDivider;
use App\Admin\Actions\Grid\BatchSendMessage;
use App\Admin\Actions\Grid\ManualSendMessage;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\WeWork\WeWorkUser as WeWorkWeWorkUser;

class WeWorkUserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WeWorkUser(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('avatar')->image(null, 50, 50);
            $grid->column('is_selected')->switch()->help('禁用无法收到消息');
            $grid->column('status')->using(WeWorkWeWorkUser::STATUS_MAP)->dot([
           1 => 'success',
           2 => 'danger',
           4 => 'info',
           5 => 'primary',
       ], 'primary')->help('成员在微信的状态');
            $grid->column('created_at')->short_datetime();
            $grid->column('updated_at')->short_datetime()->sortable();

            $grid->disableCreateButton();
            $grid->disableFilter();
            $grid->disableBatchActions();
            $grid->disableDeleteButton();
            $grid->disableRowSelector();

            $grid->perPages([20, 50, 100]);
            $grid->model()->orderBy('id', 'desc');

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->append(new ManualSendMessage());
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
        return Show::make($id, new WeWorkUser(), function (Show $show) {
            $show->field('id');
            $show->field('corp_id');
            $show->field('userid');
            $show->field('name');
            $show->field('avatar');
            $show->field('thumb_avatar');
            $show->field('alias');
            $show->field('open_user_id');
            $show->field('status');
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
        return Form::make(new WeWorkUser(), function (Form $form) {
            $form->display('id');
            $form->display('name');
            $form->switch('is_selected');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
