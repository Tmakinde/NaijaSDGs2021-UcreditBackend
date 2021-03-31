<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_bios', function (Blueprint $table) {
            $table->id();     
            $table->string('cac_no');
            $table->string('tin_no');
            $table->string('revenue');
            $table->string('capital');
            $table->string('current_debt');
            $table->string('prev_debt');
            $table->string('loan_amount');
            $table->text('loan_purpose');
            $table->bigInteger('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('business_bios');
    }
}
