<?php

namespace Database\Seeders;

use App\Repositories\Clients\Models\Client;
use App\Services\ApiTokenService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         Client::factory(1)->create([
             'name' => 'Workbooks Landing',
             'token' => ApiTokenService::generate(),
             'success_postback' => null,
             'failure_postback' => null,
         ]);
    }
}
