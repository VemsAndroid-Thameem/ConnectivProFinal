<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('appraisal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appraisal_id');
            $table->foreign('appraisal_id')->references('id')->on('appraisals')->onDelete('cascade');
            $table->text('input_value');
            $table->integer('rating');
            $table->text('is_manager');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appraisal_details');
    }
}
