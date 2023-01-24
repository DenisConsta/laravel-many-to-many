<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Front End', 'Back End', 'Design', 'UX', 'Laravel', 'VueJS'];

        foreach($data as $item){
            $new_technology = new Technology();
            $new_technology->name = $item;
            $new_technology->slug = Str::slug($item);
            $new_technology->save();
        }
    }
}
