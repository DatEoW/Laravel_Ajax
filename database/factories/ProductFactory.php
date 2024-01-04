<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
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
        $images = Storage::disk('public')->files('fake_images');
        static $img;
        return [
            'name' =>'ẻạt'.rand(0,5),
            'price'=>rand(0,50000),
                'is_sales'=>rand(0,2),
                'is_delete'=>1,
                'describe'=>fake()->text(),
                'img' => 'storage/'.$images[array_rand($images)],
        ];
    }
}
