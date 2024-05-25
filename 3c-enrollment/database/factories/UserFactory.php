<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'profile' => $this->faker->name(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'age' => $this->faker->numberBetween(18, 80),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'address' => $this->faker->address(),
            'citizenship' => $this->faker->country(),
            'religion' => $this->faker->randomElement(['Christianity', 'Islam', 'Buddhism', 'Hinduism', 'Others']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}