<?php

use App\Models\Annonce;
use App\Models\Organisateur;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\post;

uses(Tests\TestCase::class);
it('Ajoute des annonce', function () {
    $anno = new Annonce([
        'titre' => 'Annonce 1',
        'description' => 'description',
        'localisation'=>'localisation',
        'date'=>'2024-04-08 19:44:54',
        'comps'=>'comps',
    ]);
    expect($anno->titre)->toBe('Annonce 1');
    expect($anno->description)->toBe('description');
    expect($anno->localisation)->toBe('localisation');
    expect($anno->date)->toBe('2024-04-08 19:44:54');
    expect($anno->comps)->toBe('comps');
});

it('the application returns a successful response', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});