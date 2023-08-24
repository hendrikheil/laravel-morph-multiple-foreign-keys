<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type');
            $table->foreignUuid('applicant_id')->nullable()->constrained('applicants');
            $table->foreignUuid('employee_id')->nullable()->constrained('employees');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamps();

            $table->unique(['type', 'applicant_id', 'employee_id']);
        });

        DB::statement('ALTER TABLE users ADD CONSTRAINT only_one_account_relation CHECK (num_nonnulls(applicant_id, employee_id) = 1)');
    }
};
