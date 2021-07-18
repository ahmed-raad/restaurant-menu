<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Dish;
use Illuminate\Support\Str;
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
            'name'          => Str::random(15),
            'category'      => $this->faker->word(),
            'sub_category'  => $this->faker->word(),
            'image_url'     => 'https://drive.google.com/uc?id=1rJT75pjxBJFTrcFTkoOfC-EO7JLa9R0Q',
            'image_id'      => '1rJT75pjxBJFTrcFTkoOfC-EO7JLa9R0Q',
            'image_name'    => 'default.jpg',
            'description'   => $this->faker->text(300),
            'price'         => $this->faker->randomDigit(),
            'is_available'  => $this->faker->boolean(),
        ];
    }
}
