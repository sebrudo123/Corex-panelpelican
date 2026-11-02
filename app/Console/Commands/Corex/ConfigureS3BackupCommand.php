<?php

namespace App\Console\Commands\Corex;

use App\Models\BackupHost;
use App\Models\Node;
use Exception;
use Illuminate\Console\Command;

class ConfigureS3BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'corex:configure-s3-backup 
                            {--name=Cloudflare R2 Storage : Descriptive name for the S3/R2 backup host}
                            {--bucket= : Bucket name}
                            {--endpoint= : S3 / R2 API Endpoint URL}
                            {--key= : S3 / R2 Access Key ID}
                            {--secret= : S3 / R2 Secret Access Key}
                            {--region=auto : Region (auto for Cloudflare R2)}
                            {--path-style=true : Use path style endpoint (true for R2/MinIO)}';

    /**
     * The console command description.
     */
    protected $description = 'Configure a Zero-Disk S3 or Cloudflare R2 backup host and bind it to all nodes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('====================================================');
        $this->info(' Corex Panel - S3 / Cloudflare R2 Zero-Disk Backup');
        $this->info('====================================================');

        $name = $this->option('name') ?: config('corex.backup.name', 'Cloudflare R2 Storage');
        $bucket = $this->option('bucket') ?: config('corex.backup.bucket', env('COREX_S3_BUCKET'));
        $endpoint = $this->option('endpoint') ?: config('corex.backup.endpoint', env('COREX_S3_ENDPOINT'));
        $key = $this->option('key') ?: config('corex.backup.key', env('COREX_S3_KEY'));
        $secret = $this->option('secret') ?: config('corex.backup.secret', env('COREX_S3_SECRET'));
        $region = $this->option('region') ?: config('corex.backup.region', env('COREX_S3_REGION', 'auto'));
        $pathStyle = filter_var($this->option('path-style') ?: config('corex.backup.path_style', env('COREX_S3_PATH_STYLE', true)), FILTER_VALIDATE_BOOLEAN);

        if (empty($bucket) || empty($endpoint) || empty($key) || empty($secret)) {
            $this->warn('Missing S3 credentials in arguments or .env.');
            $this->line('You can configure them in .env using:');
            $this->line('  COREX_S3_BUCKET=your-bucket');
            $this->line('  COREX_S3_ENDPOINT=https://<account_id>.r2.cloudflarestorage.com');
            $this->line('  COREX_S3_KEY=your-access-key-id');
            $this->line('  COREX_S3_SECRET=your-secret-key');
            $this->line('  COREX_S3_REGION=auto');
            return 1;
        }

        try {
            $configuration = [
                'region' => $region,
                'endpoint' => $endpoint,
                'bucket' => $bucket,
                'key' => $key,
                'secret' => $secret,
                'use_path_style_endpoint' => $pathStyle,
            ];

            /** @var BackupHost $backupHost */
            $backupHost = BackupHost::query()->updateOrCreate(
                ['name' => $name],
                [
                    'schema' => 's3',
                    'configuration' => $configuration,
                ]
            );

            // Bind all active Nodes to this Zero-Disk backup host
            $nodeIds = Node::query()->pluck('id')->toArray();
            if (!empty($nodeIds)) {
                $backupHost->nodes()->sync($nodeIds);
                $this->info("✔ Backup host successfully linked to " . count($nodeIds) . " active node(s).");
            } else {
                $this->line("ℹ No nodes created yet. When nodes are added, they can use this backup host.");
            }

            $this->info("✔ S3/R2 Backup Host '{$name}' configured successfully!");
            $this->line("  Bucket   : $bucket");
            $this->line("  Endpoint : $endpoint");
            $this->line("  Region   : $region");

            return 0;
        } catch (Exception $e) {
            $this->error("Failed to configure backup host: " . $e->getMessage());
            return 1;
        }
    }
}
