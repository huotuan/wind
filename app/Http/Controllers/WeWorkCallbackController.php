<?php

namespace App\Http\Controllers;

use App\Jobs\WeWorkReplyJob;
use Illuminate\Support\Facades\Cache;
use Overtrue\LaravelWeChat\EasyWeChat;

class WeWorkCallbackController extends Controller
{
    public function callback()
    {
        $app = EasyWeChat::work()->getServer();
        $app->with(function ($message, \Closure $next) {
            $MsgType = $message->MsgType ?? '';// text|image|voice|event ..
            $key = 'callback';
            Cache::put($key, $message, 600);
            // 处理event
            switch ($MsgType) {
                case 'text':
                    dispatch(new WeworkReplyJob($message));
                break;
                case 'image':
                break;
                default:
                break;
            }
            return $next($message);
        });
        return $app->serve();
    }
}
