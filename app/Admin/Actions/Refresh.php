<?php

namespace App\Admin\Actions;

use App\Jobs\CommandJob;
use Illuminate\Http\Request;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Refresh extends Action
{
    /**
      * @return string
      */
    protected $title = '<i class="feather icon-refresh-cw" style="font-size: 1.5rem"></i>';
    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $key = 'refresh';
        // if (Cache::has($key)) {
        //     return $this->response()->error('你在'.trans_time(Cache::get($key)).'同步过，请稍后再试');
        // }
        dispatch(new CommandJob('sync_user'));
        Cache::put($key, now(), 3);
        return $this->response()->success('同步成功')->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['同步?', '同步于：'.get_agent('updated_at')];
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
        return [];
    }
}
