<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_post_skills', function (Blueprint $table) {
            $table->id('job_post_skill_id');

            $table->unsignedBigInteger('job_post_id')->nullable();
            $table->foreign('job_post_id')->references('job_post_id')->on('job_posts')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('job_post_skill')->nullable();

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
        Schema::dropIfExists('job_post_skills');
    }
}
