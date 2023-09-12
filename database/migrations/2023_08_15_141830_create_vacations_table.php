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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description');
            $table->tinyInteger('status')->default(0)->unsigned();
            $table->date('from');
            $table->date('to')->nullable();
            $table->boolean('paid');
            $table->unsignedBigInteger('user_id');
            $table->text('attached_file')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacations');
    }
};
