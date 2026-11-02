<?php

namespace App\Filament\Server\Pages;

use App\Enums\SubuserPermission;
use App\Enums\TablerIcon;
use App\Models\Server;
use App\Repositories\Daemon\DaemonFileRepository;
use BackedEnum;
use Exception;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;

class PluginMarketplace extends Page
{
    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = TablerIcon::Package;

    protected static ?string $navigationLabel = 'Plugins & Resources';

    protected static ?string $title = 'Corex 1-Click Store';

    protected string $view = 'filament.server.pages.plugin-marketplace';

    public string $search = '';

    public string $selectedCategory = 'all';

    public static function canAccess(): bool
    {
        /** @var Server|null $server */
        $server = Filament::getTenant();
        if (!$server) {
            return false;
        }

        return user()?->can(SubuserPermission::FileRead, $server) ?? false;
    }

    public function getServer(): Server
    {
        /** @var Server $server */
        $server = Filament::getTenant();

        return $server;
    }

    /**
     * Catalog of 1-Click Minecraft Plugins and FiveM Resources
     *
     * @return array<int, array<string, mixed>>
     */
    public function getCatalog(): array
    {
        return [
            // ==================== MINECRAFT PLUGINS ====================
            [
                'id' => 'luckperms',
                'name' => 'LuckPerms',
                'category' => 'minecraft',
                'category_label' => 'Minecraft (Paper/Spigot)',
                'version' => 'v5.4.140',
                'description' => 'Advanced permissions management system supporting MySQL, MariaDB, web editor, and ultra-fast caching.',
                'icon' => 'tabler-shield-check',
                'badge' => 'Essential',
                'badge_color' => 'success',
                'destination' => '/plugins',
                'filename' => 'LuckPerms.jar',
                'download_url' => 'https://download.luckperms.net/1556/bukkit/loader/LuckPerms-Bukkit-5.4.140.jar',
            ],
            [
                'id' => 'essentialsx',
                'name' => 'EssentialsX',
                'category' => 'minecraft',
                'category_label' => 'Minecraft (Paper/Spigot)',
                'version' => 'v2.20.1',
                'description' => 'The essential suite of player commands, economies, teleports, kits, warps, and server administration tools.',
                'icon' => 'tabler-tool',
                'badge' => 'Popular',
                'badge_color' => 'info',
                'destination' => '/plugins',
                'filename' => 'EssentialsX.jar',
                'download_url' => 'https://github.com/EssentialsX/Essentials/releases/download/2.20.1/EssentialsX-2.20.1.jar',
            ],
            [
                'id' => 'worldedit',
                'name' => 'WorldEdit',
                'category' => 'minecraft',
                'category_label' => 'Minecraft (Paper/Spigot)',
                'version' => 'v7.3.9',
                'description' => 'In-game world editor allowing operators to select, copy, paste, generate, and manipulate millions of blocks in seconds.',
                'icon' => 'tabler-wand',
                'badge' => 'Creative',
                'badge_color' => 'primary',
                'destination' => '/plugins',
                'filename' => 'WorldEdit.jar',
                'download_url' => 'https://cdn.modrinth.com/data/1u6JkXDu/versions/qLq3Fq8F/worldedit-bukkit-7.3.9.jar',
            ],
            [
                'id' => 'viaversion',
                'name' => 'ViaVersion',
                'category' => 'minecraft',
                'category_label' => 'Minecraft (Paper/Spigot)',
                'version' => 'v5.2.1',
                'description' => 'Allows newer Minecraft client versions to connect to older server versions seamlessly.',
                'icon' => 'tabler-arrows-left-right',
                'badge' => 'Cross-Version',
                'badge_color' => 'warning',
                'destination' => '/plugins',
                'filename' => 'ViaVersion.jar',
                'download_url' => 'https://github.com/ViaVersion/ViaVersion/releases/download/5.2.1/ViaVersion-5.2.1.jar',
            ],
            [
                'id' => 'chunky',
                'name' => 'Chunky',
                'category' => 'minecraft',
                'category_label' => 'Minecraft (Paper/Spigot)',
                'version' => 'v1.4.28',
                'description' => 'Pre-generate world chunks asynchronously to permanently eliminate player exploration lag.',
                'icon' => 'tabler-map',
                'badge' => 'Optimization',
                'badge_color' => 'success',
                'destination' => '/plugins',
                'filename' => 'Chunky.jar',
                'download_url' => 'https://cdn.modrinth.com/data/fALzjamp/versions/b8o3c1G7/Chunky-1.4.28.jar',
            ],
            [
                'id' => 'spark',
                'name' => 'spark Profiler',
                'category' => 'minecraft',
                'category_label' => 'Minecraft (Paper/Purpur)',
                'version' => 'v1.10.119',
                'description' => 'Low-overhead CPU profiler and memory inspection utility for debugging lag and tick bottlenecks.',
                'icon' => 'tabler-chart-dots-3',
                'badge' => 'Diagnostic',
                'badge_color' => 'info',
                'destination' => '/plugins',
                'filename' => 'spark.jar',
                'download_url' => 'https://cdn.modrinth.com/data/l6YH9Als/versions/9H6l7X0P/spark-1.10.119-bukkit.jar',
            ],

            // ==================== FIVEM RESOURCES ====================
            [
                'id' => 'ox_lib',
                'name' => 'ox_lib (Overextended)',
                'category' => 'fivem',
                'category_label' => 'FiveM (FXServer)',
                'version' => 'v3.28.0',
                'description' => 'Industry-standard standalone high-performance utility library providing UI notifications, inputs, and zones.',
                'icon' => 'tabler-box',
                'badge' => 'Core Lib',
                'badge_color' => 'primary',
                'destination' => '/resources',
                'filename' => 'ox_lib.zip',
                'download_url' => 'https://github.com/overextended/ox_lib/releases/latest/download/ox_lib.zip',
            ],
            [
                'id' => 'oxmysql',
                'name' => 'oxmysql Database Driver',
                'category' => 'fivem',
                'category_label' => 'FiveM (FXServer)',
                'version' => 'v2.12.0',
                'description' => 'Blazing fast MySQL/MariaDB driver wrapper using node-mysql2 with pooling for FiveM roleplay servers.',
                'icon' => 'tabler-database',
                'badge' => 'Database',
                'badge_color' => 'success',
                'destination' => '/resources',
                'filename' => 'oxmysql.zip',
                'download_url' => 'https://github.com/overextended/oxmysql/releases/latest/download/oxmysql.zip',
            ],
            [
                'id' => 'es_extended',
                'name' => 'ESX Legacy Framework',
                'category' => 'fivem',
                'category_label' => 'FiveM (FXServer)',
                'version' => 'v1.10.2',
                'description' => 'Complete FiveM Roleplay framework with inventory, jobs, economies, and player metadata systems.',
                'icon' => 'tabler-users-group',
                'badge' => 'Framework',
                'badge_color' => 'warning',
                'destination' => '/resources',
                'filename' => 'es_extended.zip',
                'download_url' => 'https://github.com/esx-framework/esx_core/releases/download/v1.10.2/es_extended.zip',
            ],
            [
                'id' => 'qb-core',
                'name' => 'QBCore Framework Core',
                'category' => 'fivem',
                'category_label' => 'FiveM (FXServer)',
                'version' => 'latest',
                'description' => 'Modern modular FiveM roleplay framework with item-based metadata and extensive event APIs.',
                'icon' => 'tabler-cpu',
                'badge' => 'Framework',
                'badge_color' => 'danger',
                'destination' => '/resources',
                'filename' => 'qb-core.zip',
                'download_url' => 'https://github.com/qbcore-framework/qb-core/archive/refs/heads/main.zip',
            ],
            [
                'id' => 'pma-voice',
                'name' => 'pma-voice 3D Spatial Audio',
                'category' => 'fivem',
                'category_label' => 'FiveM (FXServer)',
                'version' => 'v5.6.3',
                'description' => 'Ultra-low latency positional 3D VoIP system with radio channels and call phone support.',
                'icon' => 'tabler-volume',
                'badge' => 'VoIP Audio',
                'badge_color' => 'info',
                'destination' => '/resources',
                'filename' => 'pma-voice.zip',
                'download_url' => 'https://github.com/AvarianKnight/pma-voice/releases/download/v5.6.3/pma-voice.zip',
            ],
        ];
    }

    /**
     * Filtered list of plugins based on user search and active category.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getFilteredPlugins(): array
    {
        $catalog = $this->getCatalog();

        return array_values(array_filter($catalog, function ($item) {
            // Category match
            if ($this->selectedCategory !== 'all' && $item['category'] !== $this->selectedCategory) {
                return false;
            }

            // Search match
            if (!empty($this->search)) {
                $term = strtolower(trim($this->search));
                $nameMatch = str_contains(strtolower($item['name']), $term);
                $descMatch = str_contains(strtolower($item['description']), $term);
                $catMatch = str_contains(strtolower($item['category']), $term);

                return $nameMatch || $descMatch || $catMatch;
            }

            return true;
        }));
    }

    /**
     * 1-Click Install execution through Wings Daemon File API
     */
    public function installPlugin(string $pluginId): void
    {
        $server = $this->getServer();

        // Check user permission
        if (!user()?->can(SubuserPermission::FileCreate, $server)) {
            Notification::make()
                ->title('Acceso Denegado')
                ->body('No tienes permisos para escribir o crear archivos en este servidor.')
                ->danger()
                ->send();

            return;
        }

        $all = $this->getCatalog();
        $target = null;
        foreach ($all as $item) {
            if ($item['id'] === $pluginId) {
                $target = $item;
                break;
            }
        }

        if (!$target) {
            Notification::make()
                ->title('Recurso no encontrado')
                ->danger()
                ->send();

            return;
        }

        try {
            /** @var DaemonFileRepository $fileRepository */
            $fileRepository = app(DaemonFileRepository::class);

            // Trigger Wings Daemon pull directly into server container disk
            $fileRepository
                ->setServer($server)
                ->pull(
                    $target['download_url'],
                    $target['destination'],
                    [
                        'filename' => $target['filename'],
                        'foreground' => true,
                    ]
                );

            Notification::make()
                ->title("Instalación Completada")
                ->body("¡{$target['name']} ({$target['version']}) se descargó correctamente en {$target['destination']}/{$target['filename']}! Reinicia el servidor para cargar los cambios.")
                ->success()
                ->duration(6000)
                ->send();

        } catch (Exception $e) {
            Notification::make()
                ->title("Error en la descarga")
                ->body("No se pudo descargar {$target['name']}: " . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
