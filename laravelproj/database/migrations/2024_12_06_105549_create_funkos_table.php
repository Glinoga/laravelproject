<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunkosTable extends Migration
{
    public function up()
    {
        Schema::create('funkos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->boolean('sold_out')->default(false);
            $table->string('image')->nullable(); // <-- Add this line
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funkos');
    }
}
