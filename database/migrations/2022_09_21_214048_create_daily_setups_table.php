<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_setups', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['gold', 'other'])->default('gold');
            $table->integer('key')->nullable();
            $table->unsignedBigInteger('open_close_day_id');
            $table->foreign('open_close_day_id')->references('id')->on('open_close_days')->onDelete('cascade');
            $table->decimal('kyat', 20, 2);
            $table->decimal('pal', 20, 2);
            $table->decimal('yway', 20, 2);
            $table->enum('customize', ['0', '1'])->default('0');
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
        Schema::dropIfExists('daily_setups');
    }
}
