<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i<5; $i++) {
            DB::table('mst_users')->insert([
                'name' => 'Đạt ' . rand(0,10),
                'email'=>'datbandat'.$i.rand(0,10).'@gmail.com',
                'is_active'=>1,
                'is_delete'=>1,
                'password'=>bcrypt('hihi'),
            ]);
         }
    }
}
