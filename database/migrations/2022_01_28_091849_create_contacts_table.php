<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->unsignedBigInteger('business_location_id');
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade');
            $table->enum('type', ['supplier', 'customer', 'both']);
            $table->string('supplier_business_name')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile1');
            $table->string('mobile2')->nullable();
            $table->string('address')->nullable();
            $table->string('total_amount')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('customer_group_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //Indexing
            $table->index('business_id');
            $table->index('business_location_id');
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
        Schema::dropIfExists('contacts');
    }
}
