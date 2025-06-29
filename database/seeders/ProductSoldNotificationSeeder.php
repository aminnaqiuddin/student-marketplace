<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\ProductSoldNotification;

class ProductSoldNotificationSeeder extends Seeder
{
    public function run()
    {
        // Get the product with ID 4
        $product = Product::find(4);

        if (!$product) {
            $this->command->error("Product with ID 4 not found.");
            return;
        }

        // Get the owner of the product (user_id 4)
        $user = User::find($product->user_id);

        if (!$user) {
            $this->command->error("User with ID {$product->user_id} not found.");
            return;
        }

        // Create dummy order and order item
        $order = Order::create([
            'user_id' => 1, // a dummy buyer
            'name' => 'Test Buyer',
            'email' => 'testbuyer@example.com',
            'address' => '123 Test Street',
            'phone' => '0123456789',
            'total_price' => $product->price,
            'status' => 'paid',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'title' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
        ]);

        // Send the notification
        $user->notify(new ProductSoldNotification($orderItem));

        $this->command->info("Notification sent to User ID {$user->id} for product '{$product->title}'");
    }
}
