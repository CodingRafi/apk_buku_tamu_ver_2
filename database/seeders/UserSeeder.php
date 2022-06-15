<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);


        //? Membuat role Teacher 
        $rolePengawas = Role::create([
            'name' => 'pengawas',
            'guard_name' => 'web'
        ]);

        $izinpengawases = [];
        $resultPengawas = array_map(function($izinPengawas){
            return $izinPengawas;
        }, $izinpengawases);

        $rolePengawas->syncPermissions($resultPengawas);

    }
}
