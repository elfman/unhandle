<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;

class sync_question_view_count extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unhandle:sync_question_view_count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将缓存内的浏览次数保存到数据库';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Question $question)
    {
        $this->info('开始保存');

        $question->syncViewCount();

        $this->info('保存完毕');
    }
}
