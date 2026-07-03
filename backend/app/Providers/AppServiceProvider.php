<?php

namespace App\Providers;

use App\Models\AddressesModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\ReviewModel;
use App\Models\WishListModel;
use App\Policies\AddressPolicy;
use App\Policies\CartPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\WishListPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(AddressesModel::class, AddressPolicy::class);
        Gate::policy(CartModel::class, CartPolicy::class);
        Gate::policy(OrderModel::class, OrderPolicy::class);
        Gate::policy(ReviewModel::class, ReviewPolicy::class);
        Gate::policy(WishListModel::class, WishListPolicy::class);

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(10)
                ->by($this->registerRateLimitKey($request))
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many registration attempts. Please wait a minute and try again.',
                        'errors' => [],
                        'data' => [],
                    ], 429, $headers);
                });
        });
    }

    private function registerRateLimitKey(Request $request): string
    {
        return sha1(implode('|', [
            'register',
            $request->ip(),
            $request->userAgent() ?? 'unknown-device',
        ]));
    }
}
