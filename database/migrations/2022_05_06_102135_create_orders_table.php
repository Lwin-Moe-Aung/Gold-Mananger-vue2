<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('gold_weight', 100)->nullable();
            $table->decimal('gold_price', 10, 2)->default(0);

            $table->string('gem_weight', 100)->nullable();
            $table->decimal('gem_price', 10, 2)->default(0);

            $table->string('fee', 100)->nullable();
            $table->decimal('fee_price', 10, 2)->default(0);

            $table->decimal('fee_for_making', 8, 2)->default(0);
            $table->decimal('item_discount', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);

            $table->string('total_weight', 100)->nullable();
            $table->decimal('total_before', 10, 2)->default(0);
            $table->decimal('total_after', 10, 2)->default(0);
            $table->decimal('paid_money', 10, 2)->default(0);
            $table->decimal('credit_money', 10, 2)->default(0);

            $table->text('note')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
