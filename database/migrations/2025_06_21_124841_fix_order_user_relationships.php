<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;

return new class extends Migration
{
    public function up()
    {
        // First ensure the column exists and is nullable
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            }
        });

        // Now populate the user_id for existing orders
        // Option 1: If you have a relationship between orders and users
        $orders = Order::whereNull('user_id')
                     ->orWhere('user_id', 0)
                     ->get();

        foreach ($orders as $order) {
            // Example: Find user by email if you have that field
            if ($order->customer_email) {
                $user = User::where('email', $order->customer_email)->first();
                if ($user) {
                    $order->user_id = $user->id;
                    $order->save();
                }
            }

            // Fallback to admin user if no match found
            if (empty($order->user_id)) {
                $order->user_id = 1; // Your admin user ID
                $order->save();
            }
        }

        // Option 2: If you need to bulk update based on another relationship
        // DB::statement("UPDATE orders SET user_id = [your logic] WHERE user_id IS NULL OR user_id = 0");
    }

    public function down()
    {
        // Optional: Revert changes if needed
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
