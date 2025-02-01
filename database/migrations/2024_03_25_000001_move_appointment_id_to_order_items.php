<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add appointment_id to order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('appointment_id')->nullable()->after('product_id')
                  ->constrained('appointments')
                  ->onDelete('set null');
        });

        // Remove appointment_id from orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('appointment_id');
        });
    }

    public function down(): void
    {
        // Add back appointment_id to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('appointment_id')->nullable()->after('user_id')
                  ->constrained('appointments')
                  ->onDelete('set null');
        });

        // Remove appointment_id from order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('appointment_id');
        });
    }
};
