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
        Schema::create('doctor_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->enum('type',['examiner','supervisor']);
            $table->unique(['project_id','doctor_id','type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_doctors');
    }
};
