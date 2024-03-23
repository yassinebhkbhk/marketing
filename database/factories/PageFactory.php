<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\Page;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_id' => $this->faker->randomNumber(),
            'NomPage' => $this->faker->sentence(),
            'user_id' => $this->faker->numberBetween(1, 10), // Assuming user IDs range from 1 to 10
            'socialMediaId' => $this->faker->numberBetween(1, 5), // Assuming social media IDs range from 1 to 5
            'categorie' => $this->faker->word(),
            'Location' => $this->faker->city(),
            'page_access_token' => $this->faker->uuid(),
            'link' => $this->faker->optional()->url(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
