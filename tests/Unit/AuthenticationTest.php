<?php
uses(Tests\TestCase::class);
it('login Benevole', function () {
    $anno = [
        'email' => 'bene@gmail.com',
        'password' => 'password',
    ];
    $this->post('/api/login',$anno)->assertStatus(200);
});
it('login Organisateur', function () {
    $anno = [
        'email' => 'orga@gmail.com',
        'password' => 'password',
    ];
    $this->post('/api/login',$anno)->assertStatus(200);
});
it('Register Organisateur', function () {
    $anno = [
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => 'password',
    ];
    $this->post('/api/orgas',$anno)->assertStatus(200);
});
it('Register Benevole', function () {
    $anno = [
        'name' => fake()->name,
        'email' => fake()->email,
        'password' => 'password',
    ];
    $this->post('/api/benes',$anno)->assertStatus(200);
});