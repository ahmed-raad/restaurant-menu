<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dish::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->word(),
            'category'      => $this->faker->word(),
            'sub_category'  => $this->faker->word(),
            'image'         => 'default.jpg',
            'description'   => $this->faker->text(300),
            'price'         => $this->faker->randomDigit(),
            'is_available'  => $this->faker->boolean(),
        ];
    }
}
