<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('idno')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('username')->nullable(false);
            $table->string('password')->nullable(false);
            $table->integer('active')->default(0);
            $table->integer('subscribed')->default(0);
            $table->timestamps();
        });

        Schema::create('medicines', function ( Blueprint $table){
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('description')->nullable(false);
            $table->integer('user')->nullable(false);
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table){
            $table->id();
            $table->integer('doctor')->nullable();
            $table->integer('patient')->nullable(false);
            $table->string('date')->nullable(false);
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table){
            $table->id();
            $table->integer('patient')->nullable(false);
            $table->integer('payment')->nullable(false);
            $table->string('expiryTime')->nullable(false);
            $table->integer('active')->default('0');
            $table->timestamps();
        });

        Schema::create('payments', function(Blueprint $table){
            $table->id();
            $table->integer('patient')->nullable(false);
            $table->double('amount')->nullable(false);
            $table->string('reference')->nullable(false);
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
        Schema::dropIfExists('patients');
    }
}
