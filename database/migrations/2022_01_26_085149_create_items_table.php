<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');

            $table->unsignedBigInteger('business_location_id');
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('item_sku', 100);
            $table->string('gold_plus_gem_weight', 100)->nullable();
            $table->string('gem_weight', 100)->nullable();
            $table->string('fee', 100)->nullable();

            $table->string('fee_for_making', 100)->nullable();
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->string('image')->nullable();
            $table->enum('draft', ['0', '1'])->default('0');
            $table->enum('sold_out', ['0', '1'])->default('0');
            $table->enum('purchase_return', ['0', '1'])->default('0');
            $table->enum('sell_return', ['0', '1'])->default('0');

            $table->text('item_description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //Indexing
            $table->index('name');
            $table->index('product_id');
            $table->index('business_location_id');
            $table->index('created_by');
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
        Schema::dropIfExists('items');
    }
}
