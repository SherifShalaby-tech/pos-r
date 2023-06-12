<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManufacturingIdToTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('transactions', 'manufacturing_id'))
        {
            Schema::table('transactions', function (Blueprint $table)
            {
                $table->unsignedBigInteger('manufacturing_id')->nullable()->after('store_pos_id');
                $table->foreign('manufacturing_id')->references('id')->on('manufacturings')->onDelete('cascade');

            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
