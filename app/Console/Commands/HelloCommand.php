<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Overtrue\LaravelWeChat\EasyWeChat;

class HelloCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $app = EasyWeChat::work();
        $api = $app->getClient();
        $response =  $api->post(
            'cgi-bin/message/send',
            [
            'json' => [
                        "touser" => '@all',
                        "text" => [
                            "content" =>'hello，我是你的私人小助理'
                        ],
                        "agentid" => config('easywechat.work.default.agent_id'),
                        "msgtype" => "text",
                    ]
            ]
        );

        $this->info(json_encode($response->toArray()));
        return 0;
    }
}
