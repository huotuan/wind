<?php

namespace App\Jobs;

use Exception;
use EasyWeChat\Work\Message;
use Illuminate\Bus\Queueable;
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
        $corpId = $this->message->ToUserName;
        $FromUserName = $this->message->FromUserName;
        $Content = $this->message->Content;
        // info('message',[$this->message]);
        info('message', [$corpId,$FromUserName,$Content]);
        try {
            $replies = WeWorkReply::query()
        ->whereHas('user', function ($query) {
            return $query->where([
                'corp_id' => $this->message->ToUserName,
                'userid' => $this->message->FromUserName
            ]);
        })
        ->whereHas('keywords', function ($query) {
            return $query->where('keywords', 'like', '%'.$this->message->Content.'%');
        })
        ->where('status', WeWorkReply::ACTIVED)
        ->get(['title', 'content', 'id', 'recall_time', 'need_alarm', 'interval_time', 'url']);


            $this->sendMessage($replies);
        } catch (Exception $e) {
            info('回复报错', $e->getMessage());
        }
    }

    public function sendMessage($replies)
    {
        if (blank($replies)) {
            return;
        }
        $app = EasyWeChat::work();
        $api = $app->getClient();

        foreach ($replies as $reply) {
            $response = $api->post(
                'cgi-bin/message/send',
                [
                'json' => [
                        "touser" => $this->message->FromUserName,
                        "text" => [
                            "content" =>$reply->content
                        ],
                        "agentid" => $this->message->AgentID,
                        "msgtype" => "text",
                ]
            ]
            );
            info('send messege res', [$response->toArray()]);
        }
    }
}
