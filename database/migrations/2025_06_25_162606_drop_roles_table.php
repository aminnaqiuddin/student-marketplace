<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop the foreign key that links permission_role -> roles
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        // Now you can safely drop the roles table
        Schema::dropIfExists('roles');
    }

    public function down(): void
    {
        // Recreate the roles table in case you roll back
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Re-add the foreign key if rolling back
        Schema::table('permission_role', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }
};
