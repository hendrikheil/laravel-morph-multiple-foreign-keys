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
        Schema::createFunction(
            name: 'check_account_exists',
            parameters: ['_type' => 'varchar', '_id' => 'uuid'],
            return: 'boolean',
            language: 'sql',
            body: "
            select (CASE
                WHEN _type = 'applicant' THEN (SELECT EXISTS(SELECT * FROM applicants WHERE id = _id))
                ELSE false
            END)
            ",
            options: ['volatility' => 'stable']
        );

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('account_type');
            $table->uuid('account_id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamps();

            $table->unique(['account_type', 'account_id']);
        });

        DB::statement('ALTER TABLE users ADD CONSTRAINT check_account_exists CHECK (check_account_exists(account_type, account_id))');
    }
};
