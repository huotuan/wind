<?php

namespace App\Admin\Actions\Grid;

use Exception;
use Illuminate\Http\Request;
use Dcat\Admin\Grid\RowAction;
use App\Services\WeworkService;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class SendMessage extends RowAction
{
    /**
     * @return string
     */
    protected $title = '<i class="fa fa-send-o"></i>';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        try {
            $response = app(WeworkService::class)->sendTextMessage($request->userid, $request->title, $request->content);

            if (isset($response['errcode']) && $response['errcode']==0) {
                return $this->response()->success('发送成功 ');
            }
            return $this->response()->error('发送失败 '.$response['errmsg']??'');
        } catch (Exception $e) {
            return $this->response()->error('发送失败 '.$e->getMessage());
        }
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        // return ['Confirm?', 'contents'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [
            'title' => $this->row->title,
            'userid' => $this->row->user->userid,
            'content' => $this->row->content,
            'msgtype' => $this->row->msgtype,
        ];
    }
}
