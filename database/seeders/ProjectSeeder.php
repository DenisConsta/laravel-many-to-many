<?php

namespace Database\Seeders;

use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i=0; $i<100; $i++){
            $new_project = new Project();
            $new_project->name = $faker->sentence(3, true);
            $new_project->slug = Project::generateSlug($new_project->name);
            $new_project->client_name = $faker->company();
            $new_project->summary = $faker->text();
            $new_project->cover_image = $faker->imageUrl();

            $new_project->save();
        }
    }
}
