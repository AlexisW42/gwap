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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('username1')->nullable();
            $table->foreign('username1')->references('username')->on('users')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('username2')->nullable();
            $table->foreign('username2')->references('username')->on('users')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('username3')->nullable();
            $table->foreign('username3')->references('username')->on('users')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('pathImage1');
            $table->foreign('pathImage1')->references('path')->on('images')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('pathImage2');
            $table->foreign('pathImage2')->references('path')->on('images')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('pathImage3');
            $table->foreign('pathImage3')->references('path')->on('images')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('ready')->default(false);
            $table->dateTime('endTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
