<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

class EmployeeFactory extends Factory
{

    public function definition()
    {
        return [
            'first_name'=>fake()->name,
            'last_name'=>fake()->name,
            'companies_id'=>rand(1,1000)
        ];
    }
}
