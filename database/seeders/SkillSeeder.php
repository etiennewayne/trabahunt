<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                'skill' => 'SOFTWARE ENGINEER',
            ],
           
        ];

        \App\Models\Skill::insertOrIgnore($data);


    }
}
