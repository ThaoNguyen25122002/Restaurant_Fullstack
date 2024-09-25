<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        // Role::create([
        //     'name' => 'staff'
        // ]);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'role_id' => '1'
        // ]);
        Category::create([
            'category_name'=> 'Gà Rán - Gà Quay',
            'category_image' => '123',
            'slug' => 'ga-ran-ga-quay',
            'is_show' => true,
        ]);
    }
}
