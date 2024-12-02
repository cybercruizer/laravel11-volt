<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
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
           'tagihan-list',
           'tagihan-create',
           'tagihan-edit',
           'tagihan-delete',
           'pembayaran-list',
           'pembayaran-create',
           'pembayaran-edit',
           'pembayaran-delete',
           'jurusan-list',
           'jurusan-edit',
           'jurusan-delete',
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
