<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->get()->count() == 0) {
            $users = User::factory()->count(50)->create();

            foreach ($users as $key => $user) {
                if ($key === 0) {
                    $user->assignRole('admin');
                }
                else if ($key === 1) {
                    $user->assignRole('content manager');
                }
                else {
                    $user->assignRole('user');
                }
            }  
        } 
        else { 
            echo "Unable to run the seed. The table is not empty.";
            die(); 
        }
    }
}
