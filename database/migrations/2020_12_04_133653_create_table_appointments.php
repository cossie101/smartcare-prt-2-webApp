<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            
            $table->string('title')->nullable();
            $table->string('description')->nullable(false);
            $table->integer('assigned')->defalut(0);
            $table->integer('active')->defalut(1);
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor')->nullable(false);
            $table->integer('active')->defalut(0);
            $table->integer('appointment')->nullable();
            $table->timestamps();
        });

        Schema::table('status', function ( Blueprint $table ){
            $table->integer('appointment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_appointments');
    }
}
