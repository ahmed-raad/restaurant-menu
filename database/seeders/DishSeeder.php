<?php

namespace Database\Seeders;

use App\Models\Admin\Dish;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dishes = Dish::factory()->times(100)->create();
    }
}
