<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            // ▽プライマリキー
            $table->id();
            // ▽学年や等級の名称を格納するレコード
            $table->string('name', 255);
            // ▽created_at,updated_atレコード
            $table->timestamps();
        });

        // grades テーブルに初期データを挿入
        DB::table('grades')->insert([
            ['id' => 1, 'name' => '小学校1年生'],
            ['id' => 2, 'name' => '小学校2年生'],
            ['id' => 3, 'name' => '小学校3年生'],
            ['id' => 4, 'name' => '小学校4年生'],
            ['id' => 5, 'name' => '小学校5年生'],
            ['id' => 6, 'name' => '小学校6年生'],
            ['id' => 7, 'name' => '中学校1年生'],
            ['id' => 8, 'name' => '中学校2年生'],
            ['id' => 9, 'name' => '中学校3年生'],
            ['id' => 10, 'name' => '高校1年生'],
            ['id' => 11, 'name' => '高校2年生'],
            ['id' => 12, 'name' => '高校3年生'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
