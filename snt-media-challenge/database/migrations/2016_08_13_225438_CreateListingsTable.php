<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_street_address');
            $table->string('city');
            $table->string('state_or_province');
            $table->string('postal_code');
            $table->string('country');
            $table->integer('list_price')->index();
            $table->string('listing_url');
            $table->integer('bedrooms');
            $table->float('bathrooms');
            $table->string('property_type');
            $table->string('listing_key');
            $table->string('listing_category');
            $table->string('listing_status');
            $table->text('listing_description');
            $table->string('mls_id');
            $table->string('mls_name');
            $table->integer('mls_number')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listings');
    }
}
