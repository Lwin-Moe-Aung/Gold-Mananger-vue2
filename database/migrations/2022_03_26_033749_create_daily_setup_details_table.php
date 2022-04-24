<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySetupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_setup_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_setup_id');
            $table->string('quality');
            $table->decimal('daily_price_kyat', 20, 2);
            $table->decimal('daily_price_pal', 20, 2);
            $table->decimal('daily_price_yway', 20, 2);
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
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
        Schema::dropIfExists('daily_setup_details');
    }
}
