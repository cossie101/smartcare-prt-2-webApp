<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->string('title')->nullable(false);
            $table->integer('solved')->default(0);
        });

        Schema::create('status', function( Blueprint $table){
            $table->id();
            $table->integer('patient_id')->nullable(false);
            $table->integer('enquiries_id')->nullable();
            $table->intger('appointment')->nullable();
            $table->string('description', 4000)->nullable(false);
            $table->integer('user')->nullable();
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
        Schema::table('enquiries', function (Blueprint $table) {
            //
        });
    }
}
