<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Annonce;
use App\Models\benevole;
use App\Models\Organisateur;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Organisateur::factory()->create();
        benevole::factory()->create();
        Annonce::factory(10)->create();
      
    }
}