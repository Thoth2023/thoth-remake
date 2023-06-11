<?php

namespace Database\Factories;

use App\Models\SearchStrategy;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;


class SearchStrategyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SearchStrategy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->paragraph,
            'id_project' => function () {
                return Project::factory()->create()->id_project;
            },
        ];
    }
}

