<?php

namespace App\Console\Commands\Corex;

use App\Enums\EggFormat;
use App\Services\Eggs\Sharing\EggImporterService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportCorexEggsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'corex:import-eggs';

    /**
     * The console command description.
     */
    protected $description = 'Import preconfigured Corex templates (FiveM txAdmin and Minecraft Multi-Engine with Aikar flags)';

    /**
     * Execute the console command.
     */
    public function handle(EggImporterService $importer): int
    {
        $this->info('====================================================');
        $this->info(' Corex Panel - Preconfigured Egg Templates Importer');
        $this->info('====================================================');

        $eggDir = database_path('eggs/corex');
        if (!File::isDirectory($eggDir)) {
            $this->error("Directory not found: $eggDir");
            return 1;
        }

        $files = File::files($eggDir);
        if (empty($files)) {
            $this->warn("No egg files found in $eggDir");
            return 0;
        }

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $this->line("Processing template: <comment>$filename</comment>");

            try {
                $content = File::get($file->getRealPath());
                $egg = $importer->fromContent($content, EggFormat::JSON);
                $this->info(" ✔ Successfully imported/updated: {$egg->name} (UUID: {$egg->uuid})");
            } catch (Exception $e) {
                $this->error(" ✖ Failed to import {$filename}: " . $e->getMessage());
            }
        }

        $this->info('All Corex templates successfully loaded!');
        return 0;
    }
}
