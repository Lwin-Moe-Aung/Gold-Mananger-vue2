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
            $table->unsignedBigInteger('business_location_id');
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('item_sku', 100);
            $table->string('gold_weight', 100)->nullable();
            $table->string('gold_price', 100)->nullable();
            $table->string('gem_weight', 100)->nullable();
            $table->string('gem_price', 100)->nullable();
            $table->string('fee', 100)->nullable();
            $table->string('fee_for_making', 100)->nullable();
            $table->decimal('item_discount', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
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
