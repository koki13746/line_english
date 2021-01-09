<?php

use Illuminate\Database\Seeder;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\DB::table('words')->delete();

        \DB::table('words')->insert([
        'id' => '1',
        //'user_id' => '', 
        'name_english' => 'spring', //英単語
        'name_japanese' => '春' //英単語の和訳
        ]);

        \DB::table('words')->insert([
        'id' => '2',
        //'user_id' => '', 
        'name_english' => 'summer', //英単語
        'name_japanese' => '夏' //英単語の和訳
        ]);

        \DB::table('words')->insert([
        'id' => '3',
        //'user_id' => '', 
        'name_english' => 'autumn', //英単語
        'name_japanese' => '秋' //英単語の和訳
        ]);
        
        \DB::table('words')->insert([
        'id' => '4',
        //'user_id' => '', 
        'name_english' => 'winter', //英単語
        'name_japanese' => '冬' //英単語の和訳
        ]);
    }
}