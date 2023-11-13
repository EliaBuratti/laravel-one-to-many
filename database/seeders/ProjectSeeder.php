<?php

namespace Database\Seeders;

use App\Models\project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 10; $i++) {

            $project = new project();
            $project->title = $faker->words(3, true);
            $project->slug = Str::slug($project->title, '-');
            $project->description = $faker->paragraph();
            $project->cover_image = $faker->imageUrl(640, 400, 'Posts', false);
            $project->skills = implode(', ', $faker->words(5));
            $project->project_link = $faker->url();
            //dd($project);
            $project->save();
        }
    }
}
