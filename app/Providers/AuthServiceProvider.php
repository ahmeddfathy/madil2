<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Policies\OrderPolicy;
use App\Policies\DashboardPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Notifications\DatabaseNotification;
use App\Policies\NotificationPolicy;

class AuthServiceProvider extends ServiceProvider
{
  protected $policies = [
    Order::class => OrderPolicy::class,
    Product::class => ProductPolicy::class,
    DatabaseNotification::class => NotificationPolicy::class,
  ];

  public function boot(): void
  {
    $this->registerPolicies();

    // Register the dashboard gate
    Gate::define('viewDashboard', [DashboardPolicy::class, 'viewDashboard']);
  }
}
