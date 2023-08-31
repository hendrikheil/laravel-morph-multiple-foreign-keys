<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $a = new User([
            'name' => 'John Doe',
            'email' => 'test@stafftastic.com',
            'password' => 'test',
            'type' => 'applicant',
        ]);
        $a->save();

        $applicant = new Applicant([
            'user_id' => $a->id,
        ]);
        $applicant->save();

        $a->account()->associate($applicant);
        $a->save();
    }
}
