<?php namespace Ntut\AdvisoryYda\Updates;

use Carbon\Carbon;
use RainLab\User\Models\User;
use October\Rain\Database\Updates\Seeder;

class SeedAllTables extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Mark Dai',
            'surname' => 'markdai',
            'email' => 'markdai@test.com',
            'password' => '12345',
            'password_confirmation' => '12345',
            'is_activated' => 1,
            'activated_at' => Carbon::now(),
            'username' => 'markdai@test.com'
        ]);
    }
}