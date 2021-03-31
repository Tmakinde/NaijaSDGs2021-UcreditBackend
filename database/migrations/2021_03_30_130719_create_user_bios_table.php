<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bios', function (Blueprint $table) {
            $table->id();       
            $table->string('dob');
            $table->string('bvn');
            $table->string('tin');
            $table->string('nin');
            $table->string('loan_amount');
            $table->string('monthly_income');
            $table->string('expense');
            $table->text('loan_purpose');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('user_bios');
    }
}
