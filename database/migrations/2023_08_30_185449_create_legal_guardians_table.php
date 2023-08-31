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
        Schema::create('legal_guardians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('applicant_id')->constrained('applicants', 'user_id')->cascadeOnDelete();
            $table->string('test');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_guardians');
    }
};
