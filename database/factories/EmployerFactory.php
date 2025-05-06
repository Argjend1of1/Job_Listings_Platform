<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Technology & IT',
            'Healthcare & Life Sciences',
            'Finance & Business',
            'Education & Non-Profit',
            'Engineering & Industry',
            'Retail & Consumer Services',
            'Media & Design',
            'Environment & Infrastructure',
            'Logistics & Transportation',
            'Sports & Recreation'
        ];

        return [
            'name' => fake()->name(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'logo' => fake()->imageUrl(),
            'user_id' => User::factory()
        ];
    }
}
