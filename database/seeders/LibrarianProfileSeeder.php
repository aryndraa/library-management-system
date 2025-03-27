<?php

namespace Database\Seeders;

use App\Models\Librarian;
use App\Models\LibrarianProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarianProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $librariansWithoutProfile = Librarian::whereDoesntHave('profile')->pluck('id');

        $profiles = $librariansWithoutProfile->map(fn ($id) => [
            'librarian_id' => $id,
            'first_name'   => fake()->firstName(),
            'last_name'    => fake()->lastName(),
            'phone'        => fake()->phoneNumber(),
            'gender'       => fake()->randomElement(["male", "female"]),
            'birth_date'   => fake()->date(),
            'province'     => fake()->country(),
            'city'         => fake()->city(),
            'address'      => fake()->address(),
            'created_at'   => now(),
            'updated_at'   => now(),
        ])->toArray();

        LibrarianProfile::insert($profiles);
    }
}
