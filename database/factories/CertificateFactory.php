<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateFactory extends Factory
{
    protected $model = \App\Models\Certificate::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(), 
            'date_of_issue' => $this->faker->date('Y-m-d', 'now'),
            'validity_period' => $this->faker->date('Y-m-d', '+5 years'),
            'INN' => $this->faker->optional()->numerify('##########'),
            'series' => strtoupper($this->faker->bothify('??###')),
            'best_before_date' => $this->faker->date('Y-m-d', '+3 years'),
            'manufacturer' => $this->faker->company(),
        ];
    }
}
