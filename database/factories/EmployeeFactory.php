<?php

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'tipo_documento' => $faker->randomElement($array = array('Cedula de Ciudadania', 'Tarjeta de Identidad', 'Cedula de Extranjeria')),
        'documento'      => $faker->randomNumber($nbDigits = null, $strict = false),
        'nombre'         => $faker->name,
        'apellido'       => $faker->lastName,
        'direccion'      => $faker->asciify('calle ***'),
        'telefono'       => $faker->phoneNumber,
        'email'          => $faker->unique()->safeEmail,
        'estado'         => $faker->randomElement($array = array(1, 0)),
    ];
});
