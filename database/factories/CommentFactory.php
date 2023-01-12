<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::get()->random()->id,
            'blog_id' => \App\Models\Blog::get()->random()->id,
            'comment' => $this->faker->paragraph(1)
        ];
    }
}
