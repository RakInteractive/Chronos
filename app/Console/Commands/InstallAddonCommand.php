<?php

namespace App\Console\Commands;

use App\Models\Addon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class InstallAddonCommand extends Command {
    protected $signature = 'addon:install {zip? : Name of the addon zip file}';

    protected $description = 'Installs an addon from a zip file located in the addons/ directory';

    public function handle(): int {
        $zip = $this->argument('zip');

        if (!$zip) {
            $files = collect(glob(base_path('addons/*.zip')))
                ->map(fn($f) => basename($f))
                ->all();

            if (empty($files)) {
                $this->error('No Addon-Zip files found in the addons/ directory.');
                return SymfonyCommand::FAILURE;
            }

            $zip = $this->anticipate('Which addon zip file do you want to install?', $files);
        }

        try {
            $addon = Addon::install(base_path("addons/$zip"));
            $this->info("Addon '$addon->slug' successfully installed.");
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return SymfonyCommand::FAILURE;
        }

        return SymfonyCommand::SUCCESS;
    }
}
