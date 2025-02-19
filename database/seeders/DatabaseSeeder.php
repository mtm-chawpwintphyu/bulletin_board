<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
       
        if (!User::where('name', 'Admin')->exists()) {
          
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'type' => 0, // Assuming 0 is Admin type
                'created_user_id' => 1, 
                'updated_user_id' => 1, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Seed posts for the admin user
            for ($i = 1; $i <= 30; $i++) {
                DB::table('posts')->insert([
                    'title' => 'Post Title ' . $i,
                    'description' => 'This is the content for post number ' . $i,
                    'created_user_id' => $admin->id, // Admin is the creator of these posts
                    'updated_user_id' => $admin->id, // Admin is also the updater
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
