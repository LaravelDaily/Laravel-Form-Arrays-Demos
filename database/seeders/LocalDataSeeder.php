<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LocalDataSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(19)->create();
    }
}
