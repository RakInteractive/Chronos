<?php

namespace App\Providers;

use App\Services\AddonManagerService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Schema;

class AddonsServiceProvider extends ServiceProvider {
    public function register(): void {
        $manager = app(AddonManagerService::class);
        $manager->registerAutoloaders();
    }

    public function boot(): void {
        if (!Schema::hasTable('addons')) {
            return;
        }

        $manager = app(AddonManagerService::class);

        foreach ($manager->discoverProviders() as $provider) {
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }

        foreach ($manager->enabled() as $slug) {
            $resources = $manager->resources($slug);

            if (is_dir($resources['views'])) {
                View::addNamespace($slug, $resources['views']);
            }
            if (is_file($resources['routes_web'])) {
                $this->loadRoutesFrom($resources['routes_web']);
            }
            if (is_dir($resources['migrations'])) {
                $this->loadMigrationsFrom($resources['migrations']);
            }
            if (is_dir($resources['translations'])) {
                $this->loadTranslationsFrom($resources['translations'], $slug);
            }
            if (is_file($resources['schedule'])) {
                require $resources['schedule'];
            }
        }
    }
}
