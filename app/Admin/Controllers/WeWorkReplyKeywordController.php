<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\WeWorkReplyKeyword;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class WeWorkReplyKeywordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WeWorkReplyKeyword(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('reply_id');
            $grid->column('wework_user_id');
            $grid->column('keywords');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
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
        return Show::make($id, new WeWorkReplyKeyword(), function (Show $show) {
            $show->field('id');
            $show->field('reply_id');
            $show->field('wework_user_id');
            $show->field('keywords');
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
        return Form::make(new WeWorkReplyKeyword(), function (Form $form) {
            $form->display('id');
            $form->text('reply_id');
            $form->text('wework_user_id');
            $form->text('keywords');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
