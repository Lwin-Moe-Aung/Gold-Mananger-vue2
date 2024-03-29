<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitationPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limitation_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('open_close_day_id');
            $table->foreign('open_close_day_id')->references('id')->on('open_close_days')->onDelete('cascade');
            $table->decimal('price', 20, 2);
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->enum('customize', ['0', '1'])->default('0');
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
        Schema::dropIfExists('limitation_prices');
    }
}
