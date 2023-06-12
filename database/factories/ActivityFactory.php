<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use App\Models\Project;
use App\Models\User;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => User::factory()->create()->id,
            'id_module' => DB::table('module')->insert(['id_module' => 2, 'description' => 'Administratoraaaaaaaaaa']),
            'activity' => $this->faker->sentence,
            'id_project' => null,
            'time' => now(),
        ];
    }
}