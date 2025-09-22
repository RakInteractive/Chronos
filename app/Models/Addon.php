<?php

namespace App\Models;

use App\Exceptions\ChronosException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use ZipArchive;

class Addon extends Model {
    public $timestamps = false;
    protected $fillable = [
        'slug',
        'enabled',
        'installed_at',
        'last_updated_at'
    ];

    protected function casts(): array {
        return [
            'enabled' => 'boolean',
            'installed_at' => 'datetime',
            'last_updated_at' => 'datetime',
        ];
    }

    public function getMetadataAttribute() {
        $path = base_path("addons/$this->slug/addon.json");

        if (is_file($path)) {
            $json = file_get_contents($path);
            return json_decode($json, true);
        }

        return null;
    }

    /**
     * @throws ChronosException
     */
    public static function install(string $zipPath): self {
        $slug = pathinfo($zipPath, PATHINFO_FILENAME);
        $addonPath = base_path("addons/$slug");

        if (is_dir($addonPath) || self::where('slug', $slug)->exists()) {
            throw new ChronosException("Addon '$slug' already installed. To update, please use the update feature.");
        }

        mkdir($addonPath, 0755, true);
        $zip = new ZipArchive();

        if ($zip->open($zipPath) === true) {
            $zip->extractTo($addonPath);
            $zip->close();
        } else {
            throw new ChronosException("Can't open $zipPath.");
        }

        // @ToDo: Run migrations

        Artisan::call('queue:restart');

        return self::create([
            'slug' => $slug,
            'enabled' => false,
            'installed_at' => now(),
            'last_updated_at' => now(),
        ]);
    }

    /**
     * @throws ChronosException
     */
    public function updateFromZip(string $zipPath): void {
        $addonPath = base_path("addons/$this->slug");

        if (!is_dir($addonPath)) {
            throw new ChronosException("Addon '$this->slug' is not installed.");
        }

        $zip = new \ZipArchive();

        if ($zip->open($zipPath) === true) {
            $zip->extractTo($addonPath);
            $zip->close();
        } else {
            throw new ChronosException("Can't open $zipPath.");
        }

        // @ToDo: Run migrations

        $this->update([
            'last_updated_at' => now(),
        ]);

        Artisan::call('queue:restart');
    }

    public function uninstall(): void {
        $addonPath = base_path("addons/$this->slug");

        if (is_dir($addonPath)) {
            File::deleteDirectory($addonPath);
        }

        // @ToDo: Run migrations

        $this->delete();

        Artisan::call('queue:restart');
    }
}
