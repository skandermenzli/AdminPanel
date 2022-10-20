<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('name','like', '%api%')
                                ->orWhere('name','like', '%reset%')
                                ->update(['site_id' => '3']);
    }
}
