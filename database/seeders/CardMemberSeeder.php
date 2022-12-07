<?php

namespace Database\Seeders;

use App\Enums\MemberRole;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardMemberSeeder extends Seeder
{
    public function run()
    {
        DB::table('card_member')->insert([
            // card 1

            // Owner id is 1
            [
                'card_id' => 1,
                'member_id' => 1,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            //Members
            [
                'card_id' => 1,
                'member_id' => 2,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'card_id' => 1,
                'member_id' => 3,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'card_id' => 1,
                'member_id' => 4,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],

            // card 2

            // Owner id is 1
            [
                'card_id' => 2,
                'member_id' => 1,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            //Members
            [
                'card_id' => 2,
                'member_id' => 2,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'card_id' => 2,
                'member_id' => 3,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'card_id' => 2,
                'member_id' => 5,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],

            // card 3

            // Owner id is 1
            [
                'card_id' => 3,
                'member_id' => 3,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            //Members
            [
                'card_id' => 3,
                'member_id' => 1,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],

            // card 4

            // Owner id is 1
            [
                'card_id' => 4,
                'member_id' => 1,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],

            // card 1

            // Owner id is 5
            [
                'card_id' => 5,
                'member_id' => 3,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
        ]);
    }
}
