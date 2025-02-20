<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | Esta opción controla el controlador de hash predeterminado que se utilizará
    | para cifrar contraseñas en tu aplicación. Por defecto, se utiliza el
    | algoritmo bcrypt; sin embargo, puedes modificar esta opción si lo deseas.
    |
    | Soportado: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Opciones de Bcrypt
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar las opciones de configuración que se deben usar
    | cuando las contraseñas se cifran utilizando el algoritmo Bcrypt. Esto te
    | permitirá controlar el tiempo que toma cifrar la contraseña dada.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Opciones de Argon
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar las opciones de configuración que se deben usar
    | cuando las contraseñas se cifran utilizando el algoritmo Argon. Esto te
    | permitirá controlar el tiempo que toma cifrar la contraseña dada.
    |
    */

    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
    ],

];