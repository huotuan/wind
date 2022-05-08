<?php

namespace App\Admin\Actions\Grid;

use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Admin\Actions\Form\SendMessageForm;

class ManualSendMessage extends RowAction
{
    /**
     * @return string
     */
    protected $title = '<i class="fa fa-send-o"></i>';

    public function __construct()
    {
    }




    public function render()
    {
        // 实例化表单类并传递自定义参数
        $form = SendMessageForm::make();

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            // 因为此处使用了表单异步加载功能，所以一定要用 onLoad 方法
            // 如果是非异步方式加载表单，则需要改成 onShow 方法
            ->onLoad($this->getModalScript())
            ->button($this->title);
    }


    protected function getModalScript()
    {
        // 弹窗显示后往隐藏的id表单中写入批量选中的行ID
        return <<<JS
// 获取选中的ID数组
var key = {$this->getKey()};

$('#send-hello-id').val(key);

JS;
    }
}
