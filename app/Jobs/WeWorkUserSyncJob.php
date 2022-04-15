<?php

namespace App\Jobs;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use App\Models\WeWork\WeWorkUser;
use Illuminate\Queue\SerializesModels;
use Overtrue\LaravelWeChat\EasyWeChat;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class WeWorkUserSyncJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $app = EasyWeChat::work();
            $api = $app->getClient();

            $departmentResponse =  $api->get('/cgi-bin/department/list');
            $deparments = $departmentResponse->toArray();
            $responses = array_map(static function ($v) use ($api) {
                return $api->get('/cgi-bin/user/list', [
                        'query' => [
                                'department_id' => $v['id'],
                                'fetch_child' => 1,
                            ]
                        ]);
            }, $deparments['department']);

            foreach ($responses as $response) {
                $userlist = $response->toArray()['userlist'];
                $userData = collect($userlist)->map(function ($item, $key) use ($app) {
                    $item['corp_id'] = $app->getConfig()->get('corp_id');
                    return Arr::only($item, ['userid','name','corp_id','alias','thumb_avatar','mobile','avatar']);
                });
    
                $this->updateWeWorkUser($userData);
                break;
            }
        } catch (Exception $e) {
            info('sync error', [$e->getMessage()]);
        }
        echo 'user sync';
    }

    public function updateWeWorkUser($users)
    {
        foreach ($users as $user) {
            WeWorkUser::query()->updateOrCreate(Arr::only($user, ['corp_id','userid']), $user);
        }
    }
}
