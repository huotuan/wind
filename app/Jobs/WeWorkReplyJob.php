<?php

namespace App\Jobs;

use Exception;
use GuzzleHttp\Client;
use EasyWeChat\Work\Message;
use Illuminate\Bus\Queueable;
use App\Services\WeworkService;
use App\Models\WeWork\WeWorkReply;
use Illuminate\Queue\SerializesModels;
use Overtrue\LaravelWeChat\EasyWeChat;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class WeWorkReplyJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    protected Message $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $replies = WeWorkReply::query()
            ->whereHas('user', function ($query) {
                return $query->where([
                    'corp_id' => $this->message->ToUserName,
                    'userid' => $this->message->FromUserName
                ]);
            })
            ->where('digest', 'like', '%'.$this->message->Content.'%')
            ->where('status', WeWorkReply::ACTIVED)
            ->get(['title', 'content', 'id', 'recall_time', 'need_alarm', 'interval_time', 'url']);


            !blank($replies) ? $this->sendMessage($replies) : $this->inspire();
        } catch (Exception $e) {
            info('回复报错', [$e->getMessage()]);
        }
    }

    public function sendMessage($replies)
    {
        if (blank($replies)) {
            return;
        }

        foreach ($replies as $reply) {
            $response = app(WeworkService::class)->sendTextMessage($this->message->FromUserName, $reply->title, $reply->content);

            info('send messege res', $response);
        }
    }

    public function inspire()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://v1.hitokoto.cn/');
        if ($response->getStatusCode() != 200) {
            return 0;
        }
        $contents = $response->getBody()->getContents();
        $hitokoto = json_decode($contents, true);
        app(WeworkService::class)->sendTextMessage($this->message->FromUserName, $hitokoto['from']??'Hi', $hitokoto['hitokoto']??'Hi');
    }
}
