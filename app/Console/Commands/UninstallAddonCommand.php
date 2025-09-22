<?php

namespace App\Console\Commands;

use App\Models\Addon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class UninstallAddonCommand extends Command {
    protected $signature = 'addon:uninstall {slug? : Addon slug to uninstall}';

    protected $description = 'Uninstalls an installed addon';

    public function handle(): int {
        $slug = $this->argument('slug');

        if (!$slug) {
            $slugs = Addon::pluck('slug')->all();

            if (empty($slugs)) {
                $this->error('No Addons installed.');
                return SymfonyCommand::FAILURE;
            }

            $slug = $this->anticipate('Which Addon should be uninstalled.', $slugs);
        }

        $addon = Addon::where('slug', $slug)->first();

        if (!$addon) {
            $this->error("Addon '$slug' not found.");
            return SymfonyCommand::FAILURE;
        }

        $addon->uninstall();
        $this->info("Addon '$slug' successfully uninstalled.");

        return SymfonyCommand::SUCCESS;
    }
}
