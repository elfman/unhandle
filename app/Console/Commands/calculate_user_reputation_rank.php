<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class calculate_user_reputation_rank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unhandle:calculate_user_reputation_rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $this->info('刷新用户声望榜');

        $rank = User::calculateAndCacheLastWeekReputationRank();
        $rank = array_map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'last_week_add' => $item->last_week_reputation,
                'reputation' => $item->reputation,
            ];
        }, $rank);
        $this->info('上周新增声望排行榜');
        $this->table(['id', 'name', 'email', 'last_week_reputation', 'reputation'], $rank);

        $rank = User::calculateAndCacheTotalReputationRank();
        $rank = array_map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'reputation' => $item->reputation,
            ];
        }, $rank);
        $this->info('总声望排行榜');
        $this->table(['id', 'name', 'email', 'reputation'], $rank);
    }
}
