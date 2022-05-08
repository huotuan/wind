<?php

namespace App\Admin\Actions\Form;

use Dcat\Admin\Widgets\Form;
use App\Services\WeworkService;
use App\Models\WeWork\WeWorkUser;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;

class SendMessageForm extends Form implements LazyRenderable
{
    use LazyWidget;

    // 处理请求
    public function handle(array $input)
    {
        // id转化为数组
        $id = explode(',', $input['id'] ?? null);
        $title = $input['title'] ?? null;
        $message = $input['message'] ?? null;

        if (! $id) {
            return $this->response()->error('参数错误');
        }

        $users = WeWorkUser::query()->activated()->whereIn('id', $id)->pluck('userid');

        if ($users->isEmpty()) {
            return $this->response()->error('请选择成员');
        }
        $toUser = implode('|', $users->toArray());
        $res =  app(WeworkService::class)->sendTextMessage($toUser, $title, $message);
        if (isset($res['errcode']) && $res['errcode']==0) {
            return $this->response()->success('发送成功')->refresh();
        }
        return $this->response()->error('发送失败'.$res['errmsg']??'');
    }

    public function form()
    {
        $this->text('title')->required();
        $this->textarea('message')->required();

        // 设置隐藏表单，传递用户id
        $this->hidden('id')->attribute('id', 'send-hello-id');
    }

    // 返回表单数据，如不需要可以删除此方法
    public function default()
    {
        return [
            'title'   => 'Hello',
            'message' => '我是私人小助理',
        ];
    }
}
