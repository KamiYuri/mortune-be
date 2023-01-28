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
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            WorkspaceSeeder::class,
            WorkspaceMemberSeeder::class,
            BoardSeeder::class,
            BoardMemberSeeder::class,
            CardListSeeder::class,
            CardSeeder::class,
            CardMemberSeeder::class,
            TaskSeeder::class
        ]);
    }
}
