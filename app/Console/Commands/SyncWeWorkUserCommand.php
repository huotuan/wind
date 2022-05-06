<?php

namespace App\Console\Commands;

use Exception;
use App\Jobs\WeWorkUserSyncJob;
use Illuminate\Console\Command;

class SyncWeWorkUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:user';

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
        $this->getAgent();
        dispatch(new WeWorkUserSyncJob());
        return 0;
    }

    public function getAgent()
    {
        try {
            $response =   app('easywechat.work')->getClient()->get('/cgi-bin/agent/get', [
                'query'=>['agentid'=>config('easywechat.work.default.agent_id')]
            ]);

            set_agent($response->toArray());
        } catch (Exception $e) {
            //  异常信息
        }
      
    }
}
