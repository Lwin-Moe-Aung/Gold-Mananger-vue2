<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySetupsOldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('daily_setups', function (Blueprint $table) {
        //     $table->id();
        //     $table->enum('type', ['gold', 'other'])->default('gold');
        //     $table->decimal('daily_price', 20, 2);
        //     $table->unsignedBigInteger('business_id');
        //     $table->enum('customize', ['0', '1'])->default('0');
        //     $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('daily_setups');
    }
}
