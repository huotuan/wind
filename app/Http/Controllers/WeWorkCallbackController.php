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
            switch ($message->MsgType) {
                case 'text':
                    $key = 'message';
                    Cache::put($key, $message, 600);
                    dispatch(new WeWorkReplyJob($message));
                break;
            }
            return $next($message);
        });
        return $app->serve();
    }
}
