<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('permissions');
    }

    public function down(): void
    {
        // Optional: recreate the table if needed
    }
};
