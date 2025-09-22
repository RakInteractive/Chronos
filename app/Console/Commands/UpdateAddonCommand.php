<?php

namespace App\Console\Commands;

use App\Models\Addon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class UpdateAddonCommand extends Command {
    protected $signature = 'addon:update {slug? : Addon slug to update}';

    protected $description = 'Updates an installed addon from a zip file located in the addons/ directory';

    public function handle(): int {
        $slug = $this->argument('slug');

        if (!$slug) {
            $slugs = Addon::pluck('slug')->all();

            if (empty($slugs)) {
                $this->error('No Addons installed.');
                return SymfonyCommand::FAILURE;
            }

            $slug = $this->anticipate('Which Addon should be updated?', $slugs);
        }

        $addon = Addon::where('slug', $slug)->first();

        if (!$addon) {
            $this->error("Addon '$slug' not found.");
            return SymfonyCommand::FAILURE;
        }

        $zip = base_path("addons/$slug.zip");

        try {
            $addon->updateFromZip($zip);
            $this->info("Addon '$slug' successfully updated.");
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return SymfonyCommand::FAILURE;
        }

        return SymfonyCommand::SUCCESS;
    }
}
