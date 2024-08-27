<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->nullable(false)->comment('カリキュラムのタイトルを存');
            $table->string('thumbnail',255)->comment('カリキュラムのサムネイル画像を保存');
            $table->text('description');
            $table->text('video_url');
            $table->string('alway_delivery_flg')->nullable(false)->comment('ON:1,OFF:0 ONの時は配信期間に関わらず動画を常時公開する');
            $table->string('grade_id')->nullable(false)->comment('grades テーブルのidと紐づく');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculums');
    }
};
