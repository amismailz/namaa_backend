<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\City;
use App\Models\HostingPlans;
use App\Models\Society;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Artisan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use ParagonIE\Sodium\Core\Curve25519\H;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@ensign.com',
                'password' => Hash::make('12345678'),
                'phone' => '52345678',
            ]);
        }

        // if (Society::count() == 0) {
        //     Society::create([
        //         'name' => 'تجربة 1',
        //     ]);

        //     Society::create([
        //         'name' => 'تجربة 2',
        //     ]);
        // }


        $this->call([
            RolesAndPermissionsSeeder::class,
            HostingPlansSeeder::class,
//            AdminUserSeeder::class,
//            CountriesTableSeeder::class,
//            DistributorUserSeeder::class,
//            SupervisorUserSeeder::class,
        ]);
    }
}
