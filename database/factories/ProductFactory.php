<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(rand(1, 3), true);
        $slug = Str::slug($title);

        return [
            'title' => $title,
            'slug' => $slug,
            'SKU' => fake()->unique()->ean13(),
            'description' => fake()->boolean() ? fake()->sentence(rand(1, 5), true) : null,
            'price' => fake()->randomFloat(2, 5, 300),
            'discount' => fake()->boolean() ? rand(3, 10) : null,
            'quantity' => rand(0, 50),
            'thumbnail' => $this->generateImage($slug),
        ];
    }

    protected function generateImage(string $slug): string
    {
        $dirName = 'faker/products/'.$slug;
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        if (! Storage::exists($dirName)) {
            Storage::createDirectory($dirName);
        }

        /**
         * @var \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider $faker
         */
        return $dirName.'/'.$faker->image(
            dir: Storage::path($dirName),
            isFullPath: false
        );
    }
}
