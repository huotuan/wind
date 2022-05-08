<?php

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Column;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Layout\Navbar;
use App\Admin\Actions\Refresh;
use App\Admin\Extensions\ShortDatetime;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
Grid::resolving(function (Grid $grid) {
    $grid->setActionClass(\Dcat\Admin\Grid\Displayers\Actions::class);
    $grid->model()->orderBy("id", "desc");
    $grid->disableViewButton();
    $grid->showQuickEditButton();
    $grid->showDeleteButton();
    $grid->enableDialogCreate();
    $grid->disableBatchDelete();
    $grid->actions(function (\Dcat\Admin\Grid\Displayers\Actions $actions) {
        $actions->disableView();
        $actions->disableEdit();
    });
    $grid->option("dialog_form_area", ["70%", "80%"]);
});

Column::extend('short_datetime', ShortDatetime::class);

$script = <<<'JS'
        $("#grid-table > tbody > tr").on("dblclick",function(event) {
           var obj = $(this).find(".feather.icon-edit");

           if (obj.attr('unique') == "true") {
               return
           }
           if (obj.length == 1) {
               obj.trigger("click")
               obj.attr('unique',true);
           }
        })
JS;
Admin::script($script);
config(['admin.name' => get_agent('name')??'小助手']);
Admin::navbar(function (Navbar $navbar) {
    $navbar->left(Refresh::make()->render());
});
