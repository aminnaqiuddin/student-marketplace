<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $reviewers = User::where('id', '!=', 1)->take(5)->get(); // assuming seller has ID 1
        $product = Product::first(); // or change to a specific product

        foreach ($reviewers as $user) {
            Review::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'rating' => rand(3, 5),
                'comment' => 'Sample review by user ID ' . $user->id,
            ]);
        }
    }
}
