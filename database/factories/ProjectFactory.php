<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;
use App\Models\SearchStrategy;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{

    protected $model = Project::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => User::factory()->create()->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'objectives' => $this->faker->paragraph,
        ];
    }

    public function withSearchStrategy()
    {
        return $this->has(SearchStrategy::factory());
    }
}
