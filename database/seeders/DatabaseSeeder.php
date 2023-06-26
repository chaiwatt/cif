<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

  $this->call(EmployeeTypesTableSeeder::class);
        $this->call(UserPositionsTableSeeder::class);
        $this->call(EthnicitiesTableSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(PrefixesTableSeeder::class);
        $this->call(EducationLevelsTableSeeder::class);
        $this->call(EducationBranchesTableSeeder::class);
        $this->call(CompanyDepartmentsTableSeeder::class); 
        // $this->call(GendersTableSeeder::class);
        // $this->call(BanksTableSeeder::class);
        // $this->call(ProvincesTableSeeder::class);
        // $this->call(AmphursTableSeeder::class);
        // $this->call(TambolsTableSeeder::class);
        $this->call(ShiftColorsTableSeeder::class);
        $this->call(MonthsTableSeeder::class);
        $this->call(WorkSchedulesTableSeeder::class);
        $this->call(DocumentTyesTableSeeder::class);
        $this->call(YearlyHolidaysTableSeeder::class);
        $this->call(SearchFieldsTableSeeder::class);
        $this->call(AgreementUnitsTableSeeder::class);
        $this->call(AgreementsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUsersTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(ReportFieldsTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        // $this->call(ModuleGroupsTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        // $this->call(JobModulesTableSeeder::class);
        $this->call(ShifsTableSeeder::class);
        
        
        $this->call(GroupModuleJobsTableSeeder::class); 
        $this->call(ApproversTableSeeder::class); 
        
        
    }
}
