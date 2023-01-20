<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClassTypeSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(MedicalServiceSeeder::class);
        $this->call(PatientGroupSeeder::class);
        $this->call(ReligionSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(DistrictSeeder::class);
    }
}
