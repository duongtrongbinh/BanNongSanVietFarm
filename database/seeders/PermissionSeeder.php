<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Models\ModelHasRole;
use App\Models\RoleHasPermissions;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Permissions::values() as $value => $name){
            RoleHasPermissions::create([
                'permission_id' =>  $value,
                'role_id' => 1
            ]);
        }
        $user = User::query()->where('email','admin@gmail.com')->first();
        ModelHasRole::create([
            'model_id' => $user->id,
            'model_type' => 'App\Models\User',
            'role_id' => 1
        ]);

    }
}
