<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenCloseDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_close_days', function (Blueprint $table) {
            $table->id();
            $table->enum('opened', ['0', '1'])->default('0');
            $table->enum('closed', ['0', '1'])->default('0');
            $table->enum('auto_closed', ['0', '1'])->default('0');
            $table->decimal('opening_balance', 20, 2)->nullable();
            $table->decimal('closing_balance', 20, 2)->nullable();
            $table->dateTime('opening_date_time')->nullable();
            $table->dateTime('closing_date_time')->nullable();
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
        Schema::dropIfExists('open_close_days');
    }
}
