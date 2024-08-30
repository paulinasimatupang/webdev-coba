<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel.transaction_log', function (Blueprint $table) {
            $table->string('stan');
            $table->text('proc_code');
            $table->text('responsecode');
            $table->text('tx_mti');
            $table->text('rp_mti');
            $table->text('tx_amount');
            $table->text('transaction_id');
            $table->text('additional_data');
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
        Schema::dropIfExists('channel.transaction_log');
    }
}
