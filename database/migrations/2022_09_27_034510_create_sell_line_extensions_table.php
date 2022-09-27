<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellLineExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_line_extensions', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('extension_id');
            $table->foreign('extension_id')->references('id')->on('extensions')->onDelete('cascade');
            $table->unsignedBigInteger('transaction_sell_line_id');
            $table->foreign('transaction_sell_line_id')->references('id')->on('transaction_sell_lines')->onDelete('cascade');
            $table->decimal('sell_price', 15, 5)->default(0);
            $table->decimal('quantity', 15, 4);
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
        Schema::dropIfExists('sell_line_extensions');
    }
}
