<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('keyword');
            $table->text('description');
            $table->string('favicon');
            $table->string('logo');
            $table->string('background_header');
            $table->string('corporate_name');
            $table->text('address');
            $table->string('link_maps');
            $table->string('whatsapp');
            $table->string('phone');
            $table->string('email');
            $table->string('setting_chat_wa');
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
        Schema::dropIfExists('settings');
    }
}
