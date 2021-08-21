<?php

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
        // Lookup tables
        $this->call([
            RoleTableSeeder::class,
            TagsTableSeeder::class,
            TermsTableSeeder::class,
            TestTypesTableSeeder::class
        ]);

        // Test data
        if (app()->environment('local')) {
            $this->call([
                UserTableSeeder::class,
                TeachersTableSeeder::class,
                ModulesTableSeeder::class,
                StudentsTableSeeder::class,
                TestTableSeeder::class
            ]);
        }

    }
}
