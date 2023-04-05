<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManufactureCostUnitToManufacturings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manufacturings', function (Blueprint $table) {
            $table->decimal('manufacture_cost_unit', 15, 4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manufacturings', function (Blueprint $table) {
            $table->dropColumn('manufacture_cost_unit');
        });
    }
}
