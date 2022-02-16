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
        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('smtp_config_id')->unsigned();
            $table->bigInteger('template_id')->unsigned();
            $table->string('name');
            $table->string('subject');
            $table->string('email');
            $table->enum('read_status', ['queue', 'sent','failed','read']);
            $table->longText('template_html');
            $table->timestamps();
            $table->foreign('template_id')->references('id')->on('email_template');
            $table->foreign('smtp_config_id')->references('id')->on('smtp_config');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_queue');
    }
};
