<?php

namespace Database\Seeders;

use App\Models\CardList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        CardList::factory()
            ->count(4)
            ->create();
    }
}
