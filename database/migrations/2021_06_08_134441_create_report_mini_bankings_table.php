<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportMiniBankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.report_mini_banking', function (Blueprint $table) {
            $table->string('stan');
            $table->text('request_time');
            $table->text('tx_time');
            $table->text('tid');
            $table->text('mid');
            $table->text('agent_name');
            $table->text('product_name');
            $table->text('transaction_name');
            $table->text('nominal');
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
        Schema::dropIfExists('report_mini_bankings');
    }
}
