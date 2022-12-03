<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Workspace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (range(1, 3) as $i) {
            $workspace = Workspace::factory()->create();

            Board::factory()
                ->count(fake()->numberBetween(1, 1))
                ->for($workspace, 'workspace')
                ->create();
        }
    }
}
