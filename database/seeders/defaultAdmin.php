<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class defaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where("email", "admin@admin.com")->first();
        $developer = User::where("email", "ingeniousmindslab@gmail.com")->first();
        if (!$user) {
            $user = new User();
            $user->email  = "admin@admin.com";
            $user->first_name = "Admin";
            $user->last_name = "Quick";
            $user->user_name = "admin";
            $user->password = bcrypt('123456789');
            $user->gender = 1;
            $user->save();
        }

        if (!$developer) {
            $developer = new User();
            $developer->email  = "ingeniousmindslab@gmail.com";
            $developer->first_name = "Devloper";
            $developer->last_name = "Quick";
            $developer->user_name = "devloper";
            $developer->password = bcrypt('iml@123456');
            $developer->gender = 1;
            $developer->save();
        }

        
        $role = Role::create(['name' => 'Admin']);
        $role1 = Role::create(['name' => 'Developer']);
        $role2 = Role::create(['name' => 'User']);

        $user->assignRole([$role->id]);
        $developer->assignRole([$role1->id]);
    }
}