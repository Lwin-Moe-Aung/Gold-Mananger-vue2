<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->unsignedBigInteger('daily_setup_id');

            $table->string('gold_plus_gem_weight', 100)->nullable();
            $table->decimal('gold_price', 10, 2)->default(0);
            $table->string('gem_weight', 100)->nullable();
            $table->decimal('gem_price', 10, 2)->default(0);
            $table->string('fee', 100)->nullable();
            $table->decimal('fee_price', 10, 2)->default(0);

            $table->string('fee_for_making', 100)->nullable();

            $table->decimal('before_total', 10, 2)->default(0);
            $table->decimal('final_total', 10, 2)->default(0);
            $table->decimal('paid_money', 10, 2)->default(0);
            $table->decimal('credit_money', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);

            $table->text('additional_notes')->nullable();
            $table->enum('purchase_return', ['0', '1'])->default('0');
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
        Schema::dropIfExists('purchases');
    }
}
