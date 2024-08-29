<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesClearChecksTable extends Migration
{
    public function up()
    {
        Schema::create('classes_clear_checks', function (Blueprint $table) {
            // ▽プライマリキー
            $table->id();
            // ▽users,gradesテーブルのidに紐づく外部キー。onDelete('cascade')でユーザーまたは学年が削除された際に、関連するデータも削除する。
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('grade_id');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            
            // ▽カリキュラムがクリアされたかを示すフラグ（0または1）
            $table->tinyInteger('clear_flg')->default(0);
            //▽created_at,updated_atレコード
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes_clear_checks');
    }
}
