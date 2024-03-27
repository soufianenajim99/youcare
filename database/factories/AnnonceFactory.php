<?php

namespace Database\Factories;

use App\Models\Organisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organisateur_id' => Organisateur::first()->id,
            'titre' => fake()->title(),
            'description'=> fake()->sentence(),
            'localisation' => fake()->address(),
            'date' => fake()->dateTimeBetween(now(),'+30 day'),
            'comps' => fake()->sentence(),
        ];
    }
}