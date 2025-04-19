<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique();
            $table->string('name');
            $table->integer('points')->default(0);
            $table->date('member_since');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }

};