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
        
        $this->call(TaxSettingsTableSeeder::class);
        $this->call(EmployeeTypesTableSeeder::class);
        $this->call(UserPositionsTableSeeder::class);
        $this->call(EthnicitiesTableSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(PrefixesTableSeeder::class);
        $this->call(EducationLevelsTableSeeder::class);
        $this->call(EducationBranchesTableSeeder::class);
        $this->call(CompanyDepartmentsTableSeeder::class); 
        $this->call(ShiftTypesTableSeeder::class); 
        $this->call(HtmlColrsTableSeeder::class); 
        $this->call(ScheduleTypesTableSeeder::class);
        $this->call(LeaveTypesTableSeeder::class);
        $this->call(SkillBasedCostsTableSeeder::class);
        $this->call(AssessmentScoresTableSeeder::class);
        $this->call(AssessmentScoreMultiplicationsTableSeeder::class);
        $this->call(AssessmentCriteriasTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(ShiftColorsTableSeeder::class);
        $this->call(MonthsTableSeeder::class);
        $this->call(AssessableTypesTableSeeder::class);
        $this->call(DocumentTyesTableSeeder::class);
        $this->call(SearchFieldsTableSeeder::class);
        $this->call(AgreementUnitsTableSeeder::class);
        $this->call(AssessmentPurposesTableSeeder::class);
        $this->call(DiligenceAllowancesTableSeeder::class);
        $this->call(DiligenceAllowanceClassifiesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PositionHistoriesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUsersTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(ReportFieldsTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(PayDayRangesTableSeeder::class);
        $this->call(IncomeDeductsTableSeeer::class);
        $this->call(GroupModuleJobsTableSeeder::class); 
        $this->call(LeaveIncrementsTableSeeder::class); 
         
    }
}
