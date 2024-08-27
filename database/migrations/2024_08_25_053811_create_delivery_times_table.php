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
        Schema::create('delivery_times', function (Blueprint $table) {
            $table->id();
            $table->string('curriculums_id',10)->nullable(false)->comment('curriculumsテーブルのidとづく');
            $table->dateTime('delivery_from')->nullable(false)->comment('カリキュラムの公開開始日');
            $table->dateTime('delivery_to')->nullable(false)->comment('カリキュラムの公開終了日');
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
        Schema::dropIfExists('delivery_times');
    }
};
