<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::all();
        foreach ($projects as $project) {
            $type_id = Type::inRandomOrder()->first()->id;
            $project->type_id = $type_id;
            $project->update();
        }
    }
}
