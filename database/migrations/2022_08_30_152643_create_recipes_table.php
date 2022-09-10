<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->text('translations')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('quantity_product', 15, 5)->default(0);
            $table->string('multiple_units')->nullable();
            $table->decimal('other_cost', 15, 5)->default(0);
            $table->decimal('purchase_price', 15, 5);
            $table->boolean('automatic_consumption')->default(0);
            $table->boolean('price_based_on_raw_material')->default(0);
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('recipes');
    }
}
