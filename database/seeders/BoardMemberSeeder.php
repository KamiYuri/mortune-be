<?php

namespace Database\Seeders;

use App\Enums\MemberRole;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardMemberSeeder extends Seeder
{
    public function run()
    {
        DB::table('board_member')->insert([
            // Board 1

            // Owner id is 1
            [
                'board_id' => 1,
                'member_id' => 1,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            //Members
            [
                'board_id' => 1,
                'member_id' => 2,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'board_id' => 1,
                'member_id' => 3,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'board_id' => 1,
                'member_id' => 4,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],

            // Board 2

            // Owner id is 1
            [
                'board_id' => 2,
                'member_id' => 1,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            //Members
            [
                'board_id' => 2,
                'member_id' => 2,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'board_id' => 2,
                'member_id' => 3,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'board_id' => 2,
                'member_id' => 5,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],

            // Board 3

            // Owner id is 1
            [
                'board_id' => 3,
                'member_id' => 3,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            //Members
            [
                'board_id' => 3,
                'member_id' => 1,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
        ]);
    }
}
