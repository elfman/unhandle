<?php

use Illuminate\Database\Seeder;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\Tag;

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        $questions = factory(Question::class)->times(400)->make();

        Question::insert($questions->toArray());

        $tag_ids = Tag::all()->pluck('id')->toArray();
        $question_ids = \App\Models\Question::all()->pluck('id')->toArray();

        $faker = app(\Faker\Generator::class);

        $data = [];
        foreach ($question_ids as $question_id) {
            $tags = $faker->randomElements($tag_ids, rand(1, 4));
            foreach ($tags as $tag_id) {
                $item = [
                    'tag_id' => $tag_id,
                    'taggable_id' => $question_id,
                    'taggable_type' => 'App\Models\Question',
                ];
                array_push($data, $item);
            }
        }

        DB::table('taggables')->insert($data);
    }

}

