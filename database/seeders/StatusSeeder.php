<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['id' => 1, 'status' => 'на исполнении'],
            ['id' => 2, 'status' => 'исполнена частично'],
            ['id' => 3, 'status' => 'исполнена, снята с контроля'],
            ['id' => 4, 'status' => 'отменена'],
        ]);
    }
}
