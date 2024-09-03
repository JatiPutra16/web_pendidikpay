<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::create([
            'namaadmin'=>'Jati Bintang S.K.P',
            'usernameadmin'=>'admin',
            'passwordadmin'=>Hash::make('admin'),
        ]);
    }
}
