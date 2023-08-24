<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $applicant = new Applicant([
            'id' => Str::uuid(),
        ]);
        $applicant->save();

        $a = new User([
            'name' => 'John Doe',
            'email' => 'test@stafftastic.com',
            'password' => 'test',
        ]);
        $a->account()->associate($applicant);
        $a->save();
    }
}
