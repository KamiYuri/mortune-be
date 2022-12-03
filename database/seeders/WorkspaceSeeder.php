<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkspaceSeeder extends Seeder
{
    private array $owner_id = array();

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $user = User::factory()->create();

            $this->owner_id[] = $user->id;

            Workspace::factory()
                ->count(fake()->numberBetween(1, 1))
                ->for($user, 'owner')
                ->create();
        }

        $user = User::all();

        $members = array_unique(array_merge($user->random(rand(1, 5))->pluck('id')->toArray(), $this->owner_id));

        Workspace::all()->each(function ($workspace) use ($members, $user) {
            $workspace->members()->sync(
                $members
            );
        });
    }
}
