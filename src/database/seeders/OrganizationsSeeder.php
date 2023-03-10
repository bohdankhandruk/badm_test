<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            'name' => 'Test Organization #1',
            'description' => 'This is Test Organization #1',
            'trial_end' => date('Y-m-d H:i:s', strtotime('+1 week')),
            'subscribed' => 0,
            'user_id' => 1,
        ]);
        DB::table('organizations')->insert([
            'name' => 'Test Organization #2',
            'description' => 'This is Test Organization #2',
            'trial_end' => date('Y-m-d H:i:s', strtotime('-1 week')),
            'subscribed' => 1,
            'user_id' => 1,
        ]);
    }
}
