<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
Blade::directive('initials', function ($expression) {
        return "<?php echo Str::of($expression)->explode(' ')->map(fn($part) => strtoupper(mb_substr($part, 0, 1)))->take(2)->join(''); ?>";
    });
    }
}
