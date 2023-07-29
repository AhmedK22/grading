<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Standard extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supervisorStandards = ['admin','progress','Demo','presintation','technical'];
        $examinerStandards = ['comminication','progress','contribution','TeamWork','presintation','technical'];

        for($i = 0;$i<count($supervisorStandards);$i++) {

            \App\Models\Standard::factory()->create([
                'name' => $supervisorStandards[$i],
                'standardType' => 'supervisor',
                'maxMark' => '150',
            ]);
        }

        for($i = 0;$i<count($examinerStandards);$i++) {

            \App\Models\Standard::factory()->create([
                'name' => $examinerStandards[$i],
                'standardType' => 'examiner',
                'maxMark' => '150',
            ]);
        }

    }
}
