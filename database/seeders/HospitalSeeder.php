<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        $hospitals = [
            [
                'name' => 'City General Hospital',
                'address' => '123 Main St, New Delhi',
                'email' => 'info@cityhospital.com',
                'phone' => '011-12345678',
            ],
            [
                'name' => 'Sunrise Medical Center',
                'address' => '45 Sunrise Road, Mumbai',
                'email' => 'contact@sunrisemed.com',
                'phone' => '022-87654321',
            ],
            [
                'name' => 'Apollo Health Institute',
                'address' => 'Apollo Avenue, Chennai',
                'email' => 'apollo@health.com',
                'phone' => '044-99887766',
            ],
            [
                'name' => 'Fortis Hospital',
                'address' => 'Fortis Road, Bengaluru',
                'email' => 'support@fortis.in',
                'phone' => '080-55667788',
            ],
            [
                'name' => 'AIIMS Delhi',
                'address' => 'Ansari Nagar, New Delhi',
                'email' => 'aiims@nic.in',
                'phone' => '011-26588500',
            ],
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
