<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cache::flush();
        $this->call(UsersTableSeeder::class);
        $this->call(TagsTableSeeder::class);
		$this->call(QuestionsTableSeeder::class);
        $this->call(AnswersTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(VotesTableSeeder::class);
    }
}
