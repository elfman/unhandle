<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\Tag;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        $tagNames = ['php', 'vue', 'javascript', 'css', 'html5', 'android', 'python', 'java', 'c', 'c++', 'react', 'angularjs'];
        $index = 1;
        $data = array_map(function($item) use (&$index) {
            $item = [
                'zh-CN' => $item,
            ];

            $item = json_encode($item);
            return [
                'slug' => $item,
                'name' => $item,
                'order_column' => $index++,
            ];
        }, $tagNames);

        Tag::insert($data);

    }
}