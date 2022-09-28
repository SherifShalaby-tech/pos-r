<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_extensions', function (Blueprint $table) {
            $table->id();//sell_price
            $table->decimal('sell_price', 15, 2)->default(0);
            $table->unsignedBigInteger('variation_id');
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            $table->unsignedBigInteger('extension_id');
            $table->foreign('extension_id')->references('id')->on('extensions')->onDelete('cascade');
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
        Schema::dropIfExists('product_extensions');
    }
}
