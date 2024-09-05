<?php

use App\Models\Contact;
use function Pest\Faker\fake;

uses()->group('contact');

it('can store a contact', function (array $data) {
    login()->post('/contacts', [... [
        'first_name' => fake()->firstName,
        'last_name' => fake()->lastName,
        'email' => fake()->email,
        'phone' => fake()->e164PhoneNumber,
        'address' => '1 Test Street',
        'city' => 'Testerfield',
        'region' => 'Derbyshire',
        'country' => fake()->randomElement(['us', 'ca']),
        'postal_code' => fake()->postcode,
    ], ...$data])
        ->assertRedirect('/contacts')
        ->assertSessionHas('success', 'Contact created.');

    expect(Contact::latest()->first())
        ->first_name->toBeString()->not->toBeEmpty()
        ->last_name->toBeString()->not->toBeEmpty()
        ->email->toBeString()->toContain('@')
        ->phone->toBePhoneNumber()
        ->region->toBe('Derbyshire')
        ->country->toBeIn(['us', 'ca']);
})->with([
    'deafult' => [[]],
    'email with spaces' => [['email'=> '"Harsha vardhan"@gmail.com']],
    "email with .co.in" => [['email' => 'harshavardhan@gmail.co.in']],
    'postal code above 25' => [['postal_code' => str_repeat("h", 25)]]
]);
