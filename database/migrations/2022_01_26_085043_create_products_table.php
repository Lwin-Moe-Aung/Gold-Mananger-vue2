<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('product_sku', 100);
            $table->string('quality', 100);
            $table->text('description')->nullable();
            $table->string('tax', 100)->nullable();
            $table->integer('item_count')->default(0);
            $table->integer('alert_quantity')->nullable();
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->string('image', 191)->nullable();
            $table->enum('draft', ['0', '1'])->default('0');
            $table->enum('gold_and_gem_weight', ['0', '1'])->default('1');
            $table->enum('gem_weight', ['0', '1'])->default('0');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

            //Indexing
            $table->index('name');
            $table->index('product_sku');
            $table->index('business_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
