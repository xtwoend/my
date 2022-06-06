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
        Schema::table('inventory_reports', function (Blueprint $table) {
            $table->string('pallet_qty')->nullable()->after('qty');
            $table->string('total')->nullable()->after('pack_pallet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_reports', function (Blueprint $table) {
            $table->dropColumn(['pallet_qty', 'total']);
        });
    }
};
