<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'product-list',
        'product-create',
        'product-edit',
        'product-delete',
        'siswa-list',
        'siswa-create',
        'siswa-edit',
        'siswa-delete',
        'presensi-list',
        'presensi-create',
        'presensi-edit',
        'presensi-delete',
        'walikelas-list',
        'walikelas-create',
        'walikelas-edit',
        'walikelas-delete',
        'user-list',
        'user-create',
        'user-edit',
        'user-delete',
        'pengumuman-list',
        'pengumuman-create',
        'pengumuman-edit',
        'pengumuman-delete',
        'pelanggaran-list',
        'pelanggaran-create',
        'pelanggaran-edit',
        'pelanggaran-delete',
        'event-list',
        'event-create',
        'event-edit',
        'event-delete',
     ];
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name'=>$permission]);
        }

        User::create([
            'name' => 'Admin System',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin12345')
        ]);
        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
