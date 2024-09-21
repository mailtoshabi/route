<?php

namespace App\Http\Controllers;

use Faker\Factory;
use Illuminate\Http\Request;

class FakeDataController extends Controller
{
    public function index() {
    $faker = Factory::create();
    $limit = 10;
    for ($i = 0; $i < $limit; $i++) {
    echo nl2br ('Name: ' . $faker->name . ', Email Address: ' . $faker->unique()->email . ', Contact No: ' . $faker->phoneNumber . "\n");
    }
    }
}
