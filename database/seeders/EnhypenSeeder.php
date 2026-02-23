<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Group;
use App\Models\Album;
use App\Models\Member;
use App\Models\Photocard;

class EnhypenSeeder extends Seeder
{
    public function run(): void
    {
        // Group
        $group = Group::create([
            'name' => 'Enhypen',
            'debut_date' => Carbon::createFromFormat('d/m/Y', '30/11/2020')->toDateString(),
        ]);

        // Albums
        $album1 = Album::create([
            'group_id' => $group->id,
            'name' => 'THE SIN : VANISH',
            'release_date' => Carbon::createFromFormat('d/m/Y', '16/12/2025')->toDateString(),
            'track_count' => 11,
            'title_track' => 'Knife',
            'image' => 'images/albums/enha_album_1.jpg',
        ]);

        $album2 = Album::create([
            'group_id' => $group->id,
            'name' => 'ROMANCE: UNTOLD',
            'release_date' => Carbon::createFromFormat('d/m/Y', '12/07/2024')->toDateString(),
            'track_count' => 9,
            'title_track' => 'XO (Only If You Say Yes)',
            'image' => 'images/albums/enha_album_2.jpg',
        ]);

        // Members
        $members = [];

        $members[1] = Member::create([
            'group_id' => $group->id,
            'stage_name' => 'Jungwon',
            'real_name' => 'Yang Jung-won',
            'birthday' => Carbon::createFromFormat('d/m/Y', '09/02/2004')->toDateString(),
            'emoji' => '🐱',
            'nationality' => 'Korean',
            'image' => 'images/members/enha_member_1.png',
        ]);

        $members[2] = Member::create([
            'group_id' => $group->id,
            'stage_name' => 'Heeseung',
            'real_name' => 'Lee Hee-seung',
            'birthday' => Carbon::createFromFormat('d/m/Y', '15/10/2001')->toDateString(),
            'emoji' => '🐹/ 🦌',
            'nationality' => 'Korean',
            'image' => 'images/members/enha_member_2.png',
        ]);

        $members[3] = Member::create([
            'group_id' => $group->id,
            'stage_name' => 'Jay',
            'real_name' => 'Jay Park',
            'birthday' => Carbon::createFromFormat('d/m/Y', '20/04/2002')->toDateString(),
            'emoji' => '🦅/ 🐈‍⬛',
            'nationality' => 'Korean-American',
            'image' => 'images/members/enha_member_3.png',
        ]);

        $members[4] = Member::create([
            'group_id' => $group->id,
            'stage_name' => 'Jake',
            'real_name' => 'Jake Sim',
            'birthday' => Carbon::createFromFormat('d/m/Y', '15/11/2002')->toDateString(),
            'emoji' => '🐶',
            'nationality' => 'Korean-Australian',
            'image' => 'images/members/enha_member_4.png',
        ]);

        $members[5] = Member::create([
            'group_id' => $group->id,
            'stage_name' => 'Sunghoon',
            'real_name' => 'Park Sung-hoon',
            'birthday' => Carbon::createFromFormat('d/m/Y', '08/12/2002')->toDateString(),
            'emoji' => '🐧',
            'nationality' => 'Korean',
            'image' => 'images/members/enha_member_5.png',
        ]);

        $members[6] = Member::create([
            'group_id' => $group->id,
            'stage_name' => 'Sunoo',
            'real_name' => 'Kim Seon-woo',
            'birthday' => Carbon::createFromFormat('d/m/Y', '24/06/2004')->toDateString(),
            'emoji' => '🦊',
            'nationality' => 'Korean',
            'image' => 'images/members/enha_member_6.png',
        ]);

        $members[7] = Member::create([
            'group_id' => $group->id,
            'stage_name' => 'Ni-Ki',
            'real_name' => 'Nishimura Riki',
            'birthday' => Carbon::createFromFormat('d/m/Y', '09/12/2005')->toDateString(),
            'emoji' => '🐆/🐥',
            'nationality' => 'Japanese',
            'image' => 'images/members/enha_member_7.png',
        ]);

        // Photocards
        Photocard::create([
            'album_id' => $album1->id,
            'member_id' => $members[4]->id,
            'version' => 'Showcasee Live Weverse',
            'average_price' => 45.50,
            'photo' => 'images/photocards/1_4_photocard.jpg',
        ]);

        Photocard::create([
            'album_id' => $album1->id,
            'member_id' => $members[6]->id,
            'version' => 'Afterlight B',
            'average_price' => 12.00,
            'photo' => 'images/photocards/1_6_photocard.jpg',
        ]);

        Photocard::create([
            'album_id' => $album1->id,
            'member_id' => $members[7]->id,
            'version' => 'Afterlight B',
            'average_price' => 9.80,
            'photo' => 'images/photocards/1_7_2_photocard.jpg',
        ]);

        Photocard::create([
            'album_id' => $album1->id,
            'member_id' => $members[7]->id,
            'version' => 'Afterlight A',
            'average_price' => 5.00,
            'photo' => 'images/photocards/1_7_photocard.jpg',
        ]);

        Photocard::create([
            'album_id' => $album2->id,
            'member_id' => $members[5]->id,
            'version' => 'INCEPTIO',
            'average_price' => 62.50,
            'photo' => 'images/photocards/2_5_photocard.jpg',
        ]);

        Photocard::create([
            'album_id' => $album2->id,
            'member_id' => $members[6]->id,
            'version' => 'Weverse Lucky Draw',
            'average_price' => 7.00,
            'photo' => 'images/photocards/2_6_photocard.jpg',
        ]);
    }
}
