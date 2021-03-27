<?php

namespace Database\Factories;

use App\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        // 'title' => $faker->word(),
        // 'content' => $faker->paragraph(4)
                        'title' => $this->faker->title,
            'content' => $this->faker->paragraph(4)
        ];
    }
}
