<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->after('phone'); // cash or card
            $table->string('payment_status')->after('payment_method'); // pending, paid, failed
            $table->string('order_status')->after('payment_status'); // pending, processing, completed, cancelled
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'order_status']);
        });
    }
};
