<?php

use Illuminate\Database\Seeder;

class TestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \DB::table('tests')->delete();
 
        \DB::table('tests')->insert([
        'test_id' => '1', 
        //'user_id' => '',
        //'word_id' => '1',
        'mode_sort' => '0', //0が順列,1がランダム
        'mode_english' => '0', //0が英和、1が和英
        'name_japanese' => 'haru', //英単語の和訳
        'name_english' => 'spring', //英単語
        'ok' => '1', //正解
        'not_ok' => '1' //不正解
        ]);

        \DB::table('tests')->insert([
        'test_id' => '2', 
        //'user_id' => '',
        //'word_id' => '2',
        'mode_sort' => '0', //0が順列,1がランダム
        'mode_english' => '0', //0が英和、1が和英
        'name_japanese' => '夏', //英単語の和訳
        'name_english' => 'summer', //英単語
        'ok' => '1', //正解
        'not_ok' => '1' //不正解
        ]);

        \DB::table('tests')->insert([
        'test_id' => '3',
        //'user_id' => '',
        //'word_id' => '3', 
        'mode_sort' => '0', //0が順列,1がランダム
        'mode_english' => '0', //0が英和、1が和英
        'name_japanese' => '秋', //英単語の和訳
        'name_english' => 'autumn', //英単語
        'ok' => '1', //正解
        'not_ok' => '1' //不正解
        ]);

        \DB::table('tests')->insert([
        'test_id' => '4',
        //'user_id' => '',
        //'word_id' => '4', 
        'mode_sort' => '0', //0が順列,1がランダム
        'mode_english' => '0', //0が英和、1が和英
        'name_japanese' => '冬', //英単語の和訳
        'name_english' => 'winter', //英単語
        'ok' => '1', //正解
        'not_ok' => '1' //不正解
        ]);
    }
}