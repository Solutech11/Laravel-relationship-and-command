<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('tbl_passwords',function(Blueprint $table){
            $table->id();
            $table->string('platform');
            $table->string('password');
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('tbl_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tbl_passwords');
    }
};
