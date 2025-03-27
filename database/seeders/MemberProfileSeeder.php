<?php

namespace Database\Seeders;

use App\Models\Librarian;
use App\Models\LibrarianProfile;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $librariansWithoutProfile = User::whereDoesntHave('profile')->pluck('id');

        $profiles = $librariansWithoutProfile->map(fn ($id) => [
            "user_id"    => $id,
            "first_name" => fake()->firstName(),
            "last_name"  => fake()->lastName(),
            "phone"      => fake()->phoneNumber(),
            "birthday"   => fake()->date(),
            "gender"     => fake()->randomElement(["male", "female"]),
            "address"    => fake()->address(),
            "province"   => fake()->country(),
            "city"       => fake()->city(),
        ])->toArray();

        MemberProfile::insert($profiles);
    }
}
