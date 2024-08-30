<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messagelogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('messagelog', function (Blueprint $table) {
            $table->string('message_id');
            $table->text('terminal_id');
            $table->text('service_id');
            $table->text('request_time');
            $table->text('reply_time');
            $table->text('log_id');
            $table->text('message_status');
            $table->text('request_message');
            $table->text('response_message');
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
        //
    }
}
