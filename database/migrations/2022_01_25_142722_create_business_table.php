<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->date('start_date')->nullable();
            $table->string('tax', 100)->nullable();
            $table->string('default_tax', 100)->nullable();
            $table->float('default_profit_percent', 5, 2)->default(0);
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('accounting_method', ['fifo', 'lifo', 'avco'])->default('fifo');
            $table->decimal('default_sales_discount', 5, 2)->nullable();
            $table->enum('sell_price_tax', ['includes', 'excludes'])->default('includes');
            $table->string('logo')->nullable();
            $table->text('keyboard_shortcuts')->nullable();
            $table->text('pos_setting')->nullable();
            $table->string('date_format')->nullable();
            $table->enum('time_format', ['12', '24'])->default('24');
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->timestamps();

            //Indexing
            $table->index('name');
            $table->index('owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business');
    }
}
