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
        $this->call(InstallationSeeder::class);
        $this->call(ClassTypeSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(MedicalServiceSeeder::class);
        $this->call(ReligionSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(DTDSeeder::class);
        $this->call(ICDSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(RoomSpaceSeeder::class);
        $this->call(BedSeeder::class);
        $this->call(ActionSeeder::class);
        $this->call(ActionOtherSeeder::class);
        $this->call(ActionOperativeSeeder::class);
        $this->call(ActionNonOperativeSeeder::class);
        $this->call(ActionSupportingSeeder::class);
        $this->call(ActionEmergencyCareSeeder::class);
        $this->call(PatientGroupSeeder::class);
        $this->call(OperatingRoomActionSeeder::class);
        $this->call(OperatingRoomActionTypeSeeder::class);
        $this->call(OperatingRoomAnesthetistSeeder::class);
        $this->call(OperatingRoomGroupSeeder::class);
        $this->call(FunctionalServiceSeeder::class);
        $this->call(HealthServiceBedSeeder::class);
        $this->call(UnitActionSeeder::class);
        $this->call(LabCategorySeeder::class);
        $this->call(LabItemSeeder::class);
        $this->call(LabItemParentSeeder::class);
        $this->call(LabItemOptionSeeder::class);
        $this->call(LabItemGroupSeeder::class);
        $this->call(LabFeeSeeder::class);
        $this->call(LabItemConditionSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(RadiologySeeder::class);
        $this->call(RadiologyActionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RoleAccessSeeder::class);
        $this->call(PatientSeeder::class);
    }
}
