<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Top Header & Filter Controls -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-xl bg-gray-900/60 border border-gray-800 shadow-lg">
            <div class="flex-1 max-w-md">
                <label for="plugin-search" class="sr-only">Buscar recursos</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <x-filament::icon icon="tabler-search" class="w-5 h-5" />
                    </div>
                    <input
                        id="plugin-search"
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="Buscar plugins (LuckPerms, ox_lib, Essentials, etc.)..."
                        class="w-full pl-10 pr-4 py-2 bg-gray-950 border border-gray-700/80 rounded-lg text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition"
                    />
                </div>
            </div>

            <!-- Category Pills -->
            <div class="flex items-center space-x-2">
                <button
                    wire:click="$set('selectedCategory', 'all')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold font-mono transition {{ $selectedCategory === 'all' ? 'bg-cyan-500 text-black shadow-lg shadow-cyan-500/20' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}"
                >
                    Todos
                </button>
                <button
                    wire:click="$set('selectedCategory', 'minecraft')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold font-mono transition {{ $selectedCategory === 'minecraft' ? 'bg-emerald-500 text-black shadow-lg shadow-emerald-500/20' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}"
                >
                    ⛏️ Minecraft
                </button>
                <button
                    wire:click="$set('selectedCategory', 'fivem')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold font-mono transition {{ $selectedCategory === 'fivem' ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}"
                >
                    🏎️ FiveM
                </button>
            </div>
        </div>

        <!-- Grid of Cards -->
        @php
            $plugins = $this->getFilteredPlugins();
        @endphp

        @if(empty($plugins))
            <div class="flex flex-col items-center justify-center p-12 text-center rounded-xl bg-gray-900/40 border border-gray-800">
                <x-filament::icon icon="tabler-package-off" class="w-12 h-12 text-gray-600 mb-3" />
                <h3 class="text-base font-semibold text-gray-300">No se encontraron recursos</h3>
                <p class="text-xs text-gray-500 mt-1">Prueba con otro término de búsqueda o cambia la categoría.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($plugins as $plugin)
                    <div class="flex flex-col justify-between p-5 rounded-xl bg-gray-900/70 border border-gray-800 hover:border-cyan-500/40 transition duration-200 group hover:shadow-xl hover:shadow-cyan-500/5">
                        <div>
                            <!-- Header: Icon, Name, Category -->
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2.5 rounded-lg bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 group-hover:scale-105 transition">
                                        <x-filament::icon :icon="$plugin['icon']" class="w-6 h-6" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-white group-hover:text-cyan-400 transition">
                                            {{ $plugin['name'] }}
                                        </h4>
                                        <span class="text-[11px] font-mono text-gray-400 block">
                                            {{ $plugin['category_label'] }}
                                        </span>
                                    </div>
                                </div>

                                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full uppercase tracking-wider font-semibold bg-gray-800 text-gray-300 border border-gray-700">
                                    {{ $plugin['version'] }}
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="text-xs text-gray-400 mt-3.5 leading-relaxed line-clamp-3">
                                {{ $plugin['description'] }}
                            </p>

                            <!-- Destination Path -->
                            <div class="mt-4 flex items-center justify-between text-[11px] font-mono text-gray-500 bg-gray-950/60 p-2 rounded-lg border border-gray-800/80">
                                <span>Destino:</span>
                                <span class="text-gray-300">{{ $plugin['destination'] }}/{{ $plugin['filename'] }}</span>
                            </div>
                        </div>

                        <!-- Install Action Button -->
                        <div class="mt-5 pt-4 border-t border-gray-800/80">
                            <button
                                wire:click="installPlugin('{{ $plugin['id'] }}')"
                                wire:loading.attr="disabled"
                                wire:target="installPlugin('{{ $plugin['id'] }}')"
                                class="w-full flex items-center justify-center space-x-2 py-2 px-4 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-black font-semibold font-mono text-xs tracking-wider uppercase transition shadow-md shadow-cyan-500/15 disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="installPlugin('{{ $plugin['id'] }}')">
                                    ⚡ Instalar en 1-Click
                                </span>
                                <span wire:loading wire:target="installPlugin('{{ $plugin['id'] }}')" class="flex items-center space-x-2">
                                    <x-filament::icon icon="tabler-loader-2" class="w-4 h-4 animate-spin text-black" />
                                    <span>Descargando...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>
