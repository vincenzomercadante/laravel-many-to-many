<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $project = new Project;

        $project->title = 'Vite Boolzap';
        $project->slug = Str::slug($project->title);
        $project->type_id = 1;
        $project->github_reference = 'https://github.com/vincenzomercadante/vite-boolflix';
        $project->description = 'A chat application with Vite+Vue';

        $project->save();
    }
}
