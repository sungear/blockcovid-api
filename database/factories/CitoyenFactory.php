<?php

namespace Database\Factories;

use App\Models\Citoyen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CitoyenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Citoyen::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_citoyen' => Str::random(37),
            'token_fcm' => Str::random(164),
        ];
    }

    public function first_registration_or_id_lost()
    {
        return $this->state([
            'id_citoyen' => null,
        ]);
    }
    
    public function new_fcm_token()
    {
        return $this->state(function (array $attributes) {
            return [
                'id_citoyen' => $attributes['id_citoyen'],
                'token_fcm' => Str::random(164),
            ];
        });
    }
}
