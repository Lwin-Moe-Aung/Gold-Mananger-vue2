<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('item_sku',100);
            $table->decimal('default_purchase_price', 8, 2)->nullable();
            $table->decimal('dpp_inc_tax', 8, 2)->default(0);
            $table->decimal('profit_percent', 8, 2)->default(0);
            $table->decimal('default_sell_price', 8, 2)->nullable();
            $table->decimal('sell_price_inc_tax', 8, 2)->comment("Sell price including tax")->nullable();
            $table->timestamps();
            $table->softDeletes();

            //indexing
            $table->index('item_id');
            $table->index('item_sku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variations');
    }
}
