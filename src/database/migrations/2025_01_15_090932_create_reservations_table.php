<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shop_id');
            $table->integer('num_of_users');
            $table->dateTime('start_at');
            $table->integer('rating')->nullable(); // 評価を保存するカラム
            $table->text('comment')->nullable(); // コメントを保存するカラム
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
            if (Schema::hasColumn('reservations', 'shop_id')) {
                $table->dropForeign(['shop_id']);
            }
        });
        Schema::dropIfExists('reservations');
    }
}