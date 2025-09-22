<?php

namespace App\Services;

use App\Models\Addon;
use Composer\Autoload\ClassLoader;

class AddonManagerService {
    public function enabled(): array {
        return Addon::where('enabled', true)->pluck('slug')->all();
    }

    public function path(string $slug): string {
        return base_path("addons/{$slug}");
    }

    public function namespace(string $slug): string {
        return $slug . '\\';
    }

    public function registerAutoloaders(): void {
        /** @var ClassLoader $loader */
        $loader = require base_path('vendor/autoload.php');

        $addonsPath = base_path('addons');

        foreach (glob($addonsPath . '/*', GLOB_ONLYDIR) as $path) {
            $namespace = $this->namespace(basename($path));
            $srcPath = $path . '/src';

            if (is_dir($srcPath)) {
                $loader->addPsr4($namespace, $srcPath);
            }
        }
    }

    public function discoverProviders(): array {
        $providers = [];

        foreach ($this->enabled() as $slug) {
            $cls = $this->namespace($slug) . 'Providers\\AddonServiceProvider';
            $file = $this->path($slug) . '/src/Providers/AddonServiceProvider.php';

            if (is_file($file)) {
                $providers[] = $cls;
            }
        }

        return $providers;
    }

    public function resources(string $slug): array {
        $base = $this->path($slug);

        return [
            'views' => $base . '/resources/views',
            'routes_web' => $base . '/routes/web.php',
            'schedule' => $base . '/routes/schedule.php',
            'migrations' => $base . '/database/migrations',
            'translations' => $base . '/resources/lang',
        ];
    }

}
