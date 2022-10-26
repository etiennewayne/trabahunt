<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id('job_post_id');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('company_id')->on('companies')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('title')->nullable();
            $table->text('job_desc')->nullable();

            $table->unsignedBigInteger('jobtype_id')->nullable();
            $table->foreign('jobtype_id')->references('jobtype_id')->on('job_types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('category_id')->on('categories')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('salary')->nullable();
            
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
        Schema::dropIfExists('job_posts');
    }
}
