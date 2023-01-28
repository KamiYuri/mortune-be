<?php

namespace Database\Seeders;

use App\Enums\MemberRole;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkspaceMemberSeeder extends Seeder
{
    public function run()
    {
        DB::table('member_workspace')->insert([
            // Workspace 1

            // Owner id is 1
            [
                'workspace_id' => 1,
                'member_id' => 1,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            // Members
            [
                'workspace_id' => 1,
                'member_id' => 2,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 1,
                'member_id' => 3,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 1,
                'member_id' => 4,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 1,
                'member_id' => 5,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 1,
                'member_id' => 6,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],


            // Workspace 2

            // Owner id is 2
            [
                'workspace_id' => 2,
                'member_id' => 2,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            // Members
            [
                'workspace_id' => 2,
                'member_id' => 1,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 2,
                'member_id' => 3,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 2,
                'member_id' => 4,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 2,
                'member_id' => 7,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'workspace_id' => 2,
                'member_id' => 8,
                'role' => MemberRole::Member,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],

            // Workspace 3

            // Owner id is 9
            [
                'workspace_id' => 3,
                'member_id' => 9,
                'role' => MemberRole::Owner,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            // Members
            // null
        ]);
    }
}
