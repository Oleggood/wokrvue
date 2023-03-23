<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'role' => 'администратор'],
            ['id' => 2, 'role' => 'НОПиК'],
            ['id' => 3, 'role' => 'большой начальник'],
            ['id' => 4, 'role' => 'пользователь с БД'],
            ['id' => 5, 'role' => 'пользователь без БД'],
        ]);
    }
}
