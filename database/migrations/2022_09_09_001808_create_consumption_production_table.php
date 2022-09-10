<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumptionProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumption_production', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raw_material_id')->comment('recipe table id as raw material');
            $table->unsignedBigInteger('production_id')->comment('production table id with consumed the recipes');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('amount_used', 15, 5)->default(0);
            $table->foreign('raw_material_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

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
        Schema::dropIfExists('consumption_production');
    }
}
