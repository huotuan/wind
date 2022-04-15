<?php

namespace App\Console\Commands;

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
        dispatch(new WeWorkUserSyncJob());
        return 0;
    }
}
