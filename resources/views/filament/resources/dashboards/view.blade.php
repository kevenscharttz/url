<x-filament-panels::page>
    <div class="w-full">

        <!-- CABEÇALHO SUPERIOR -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Dashboard Vendas Executivo
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Dashboard executivo com métricas de vendas e performance
                    </p>
                </div>
                
                <!-- TAGS/BADGES -->
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                        Power BI
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                        vendas
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                        executivo
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                        KPI
                    </span>
                </div>
            </div>
        </div>

        <!-- CONTAINER DO DASHBOARD -->
        <div 
            x-data="{ loaded: false }"
            class="relative w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
        >
            <!-- LOADER COM ANIMAÇÃO -->
            <div 
                x-show="!loaded"
                class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 z-10"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div class="flex flex-col items-center space-y-4 max-w-xs text-center">
                    <!-- Ícone de pasta com gráfico (similar à imagem) -->
                    <div class="relative">
                        <svg class="w-20 h-20 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-1 12H5V8h14v10z"/>
                            <path d="M7 10h2v5H7zm3 2h2v3h-2zm3-1h2v4h-2z" fill="currentColor" opacity="0.7"/>
                        </svg>
                        <div class="absolute -top-1 -right-1">
                            <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            Carregando Dashboard...
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Conectando-se ao Power BI
                        </p>
                    </div>
                    
                    <!-- Barra de progresso animada -->
                    <div class="w-48 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- IFRAME RESPONSIVO -->
            <iframe
                id="dashboardFrame"
                src="{{ $dashboard->url }}"
                class="w-full h-[70vh] sm:h-[75vh] lg:h-[80vh] border-0 block"
                loading="lazy"
                x-on:load="loaded = true"
                allow="fullscreen"
            ></iframe>
        </div>

        <!-- INFORMAÇÕES RODAPÉ -->
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Organização: <strong class="text-gray-700 dark:text-gray-300">Acme Corp</strong></span>
            </div>
            
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Criado por: <strong class="text-gray-700 dark:text-gray-300">Ana Silva</strong> em 15/01/2024</span>
            </div>
        </div>

    </div>
</x-filament-panels::page>