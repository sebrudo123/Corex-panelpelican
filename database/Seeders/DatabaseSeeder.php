<?php

namespace Database\Seeders;

use App\Models\Plugin;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => Role::ROOT_ADMIN]);

        // Auto-seed Corex templates (FiveM txAdmin and Minecraft Multi-Engine)
        try {
            \Illuminate\Support\Facades\Artisan::call(\App\Console\Commands\Corex\ImportCorexEggsCommand::class);
            if (env('COREX_S3_BUCKET') && env('COREX_S3_KEY')) {
                \Illuminate\Support\Facades\Artisan::call(\App\Console\Commands\Corex\ConfigureS3BackupCommand::class);
            }
        } catch (\Throwable $e) {
            // Ignore during early bootstrap
        }

        $plugins = Plugin::query()->orderBy('load_order')->get();
        foreach ($plugins as $plugin) {
            if (!$plugin->shouldLoad()) {
                continue;
            }

            if ($seeder = $plugin->getSeeder()) {
                $this->call($seeder);
            }
        }
    }
}
