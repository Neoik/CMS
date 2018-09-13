<?php

use Faker\Generator as Faker;

$factory->define(App\Shipping::class, function (Faker $faker) {
    $ports_count = App\Port::count();
    $rand_departure_port_id = $faker->numberBetween(1, $ports_count);
    while (true) {
        $rand_arival_port_id = $faker->numberBetween(1, $ports_count);
        if ($rand_arival_port_id != $rand_departure_port_id) break;
    }
    $rand_status = $faker->numberBetween(0, 4);
    $rand_user_id = $faker->numberBetween(1, App\User::count());
    return [
        'departure_port_id' => $rand_departure_port_id,
        'arrival_port_id' => $rand_arival_port_id,
        'status' => $rand_status,
        'cost' => $faker->randomFloat(1, 0, 5),
        'user_id' => $rand_user_id,
        'remarks' => 'remark',
    ];
});
