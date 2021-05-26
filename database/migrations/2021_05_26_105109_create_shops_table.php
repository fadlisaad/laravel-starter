<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->decimal('lng', 10, 8);
            $table->decimal('lat', 11, 8);
            $table->text('address');
            $table->string('phone_number');
            $table->string('email');
            $table->text('description');
            $table->string('person_in_charge');
            $table->tinyInteger('status')->unsigned();
            $table->timestamp('request_time');
            $table->timestamp('response_time')->nullable();
            $table->string('category_uuid')->nullable();
            $table->string('creator_user_uuid')->nullable();
            $table->string('store_uuid')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
