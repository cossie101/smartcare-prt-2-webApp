<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id();
            $table->integer('disease')->nullable();
            $table->integer('patient')->nullable();
            $table->integer('doctor')->nullable();
            $table->timestamps();
        });


        Schema::create('diseases', function (Blueprint $table){
            $table->id();
            $table->string('code')->nullable();
            $table->string('disease')->nullable(false);
            $table->integer('active')->default(1);
            $table->timestamps();
        });

        Schema::create('symptoms', function (Blueprint $table){
            $table->id();
            $table->string('code')->nullable();
            $table->string('symptom')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
        });

        Schema::create('symptoms_allocations', function( Blueprint $table){
            $table->id();
            $table->integer('disease')->nullable();
            $table->integer('symptom')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('diagnosis');
    }
}
