<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('company_id');
            $table->string('company')->nullable();
            $table->string('owner')->nullable();
            $table->string('history')->nullable();
            $table->string('overview')->nullable();

            $table->string('company_size')->nullable();
            $table->string('industry')->nullable();
            $table->string('benefits_others')->nullable();

            $table->string('phone_contact')->nullable();
            $table->string('fb_contact')->nullable();
            $table->string('twitter_contact')->nullable();
            $table->string('insta_contact')->nullable();
            $table->string('viber_contact')->nullable();
            $table->string('whatsapp_contact')->nullable();

            $table->text('desc')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('street')->nullable();

            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
