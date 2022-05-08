<?php

namespace App\Services;

use Exception;

class WeworkService
{
    protected $client;
    public function __construct()
    {
        $this->client = app('easywechat.work')->getClient();
    }

    public function getAgent()
    {
        try {
            $response =   $this->client->get('/cgi-bin/agent/get', [
                'query'=>['agentid'=>config('easywechat.work.default.agent_id')]
            ]);

            return set_agent($response->toArray());
        } catch (Exception $e) {
            // todo 异常信息
        }
        return [];
    }

    /*
    * $toUser @all,userid1|userid2
    */
    public function sendTextMessage(mixed $toUser=null, $title ='', $message='')
    {
        if (blank($toUser)) {
            $toUser = '@all';
        }
        try {
            $response =   $this->client->post(
                'cgi-bin/message/send',
                [
                'json' => [
                            "touser" => $toUser,
                            "text" => [
                                "content" =>"{$title}\n{$message}"
                            ],
                            "agentid" => config('easywechat.work.default.agent_id'),
                            "msgtype" => 'text',
                        ]
                ]
            );
            return $response->toArray();
        } catch (Exception $e) {
            // todo 记录
        }

        return [];
    }
}
