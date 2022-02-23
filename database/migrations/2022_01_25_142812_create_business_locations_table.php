<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->string('name', 191);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('division', 100);
            $table->string('country', 100);
            $table->char('zip_code', 7);
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //Indexing
            $table->index('business_id');
            $table->index('name');
            $table->index('zip_code');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_locations');
    }
}
