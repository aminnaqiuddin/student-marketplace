<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Assign orders to a specific user (e.g., admin)
        \DB::table('orders')
            ->whereNull('user_id')
            ->orWhere('user_id', 0)
            ->update(['user_id' => 5]); // Replace 1 with actual user ID
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
