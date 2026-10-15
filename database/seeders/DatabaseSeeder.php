<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Khairi Ibnutama',
            'email' => 'mr.ibnutama@gmail.com',
            'username' => 'developer',
            'is_staff' => true,
            // use Illuminate\Support\Facades\Hash; <-- import di atas
            'password' => Hash::make('rahasia'),
        ]);

        // Buat akun siswa contoh
        $siswaUser = User::factory()->create([
            'name' => 'Ahmad Siswa',
            'email' => 'ahmad@siswa.test',
            'username' => '2026020001',  // NIS sebagai username untuk login
            'is_staff' => false,
            'password' => Hash::make('rahasia'),  // password: rahasia
        ]);

        // Buat data Student terhubung ke User
        \App\Models\Student::create([
            'user_id'  => $siswaUser->id,
            'nis'      => '2026020001',
            'name'     => 'Ahmad Siswa',
            'gender'   => true,
            'reg_year' => 2026,
            'status'   => 1,
        ]);
    }
}
