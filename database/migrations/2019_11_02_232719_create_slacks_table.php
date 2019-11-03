<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->index()->unique();
            $table->string('team_id')->index();
            $table->string('team_name');
            $table->text('access_token');
            $table->json('data')->nullable();
            $table->json('settings')->nullable();
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
        Schema::dropIfExists('slacks');
    }
}
