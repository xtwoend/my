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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onUpdate('cascade');
            $table->foreignId('rack_id')->nullable()->constrained()->onUpdate('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained()->onUpdate('cascade');
            $table->string('gtin', 14)->index();
            $table->string('line', 20)->nullable();
            $table->datetime('scan_time');
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
        Schema::dropIfExists('inventories');
    }
};
