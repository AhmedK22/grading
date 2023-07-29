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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('objective');
            $table->text('description');
            $table->dateTime('date_of_exam')->nullable();
            $table->integer('num_of_students');
            $table->integer('max_mark');
            $table->json('skills');
            $table->enum('status',['approved','pending'])->default('pending');
            $table->enum('lastStatus',['approved','pending'])->default('pending');
            $table->enum('project_type',['search','creation']);
            $table->enum('type',['single','double']);
            $table->text('background');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
