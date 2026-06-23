<aside x-data="{ 
    openAdmin: @json(request()->routeIs('users.*', 'branches.*')), 
    openConfig: @json(request()->routeIs('settings.*', 'payment-methods.*')) 
}" 
class="bg-white border-r border-gray-200 w-64 flex flex-col h-screen shrink-0">
    
    <div class="h-16 flex items-center px-6 border-b border-gray-100 bg-white">
        <div class="flex flex-col">
            <span class="font-bold text-lg text-red-600 tracking-tight leading-tight">AlChile</span>
            <span class="text-[11px] font-medium text-gray-400 uppercase tracking-widest leading-none">Guadalupe</span>
        </div>
    </div>
    
    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
        
        <div>
            <h3 class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Operaciones</h3>
            <div class="space-y-0.5">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-home class="w-5 h-5 text-gray-400" /> Dashboard
                </x-nav-link>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-shopping-bag class="w-5 h-5 text-gray-400" /> Caja
                </x-nav-link>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-document-text class="w-5 h-5 text-gray-400" /> Facturas
                </x-nav-link>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-user-plus class="w-5 h-5 text-gray-400" /> Clientes
                </x-nav-link>
            </div>
        </div>

        <div>
            <h3 class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Inventario</h3>
            <div class="space-y-0.5">
                <x-nav-link :href="route('product.index')" :active="request()->routeIs('product.*')" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-archive-box class="w-5 h-5 text-gray-400" /> Productos
                </x-nav-link>
                <x-nav-link :href="route('products_categories.index')" :active="request()->routeIs('products_categories.*')"  class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-tag class="w-5 h-5 text-gray-400" /> Categorias
                </x-nav-link>
                <x-nav-link :href="route('products_stock.index')" :active="request()->routeIs('products_stock.*')" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-arrows-right-left class="w-5 h-5 text-gray-400" /> Inventario
                </x-nav-link>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-truck class="w-5 h-5 text-gray-400" /> Transferencias
                </x-nav-link>
            </div>
        </div>

        <div>
            <button @click="openAdmin = !openAdmin" class="flex w-full items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                <div class="flex items-center gap-3">
                    <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-gray-400" /> Administración
                </div>
                <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400 transition-transform duration-200" x-bind:class="openAdmin ? 'rotate-180' : ''" />
            </button>
            <div x-show="openAdmin" x-collapse class="mt-1 ml-4 border-l border-gray-200 space-y-0.5 pl-2">
                <p class="px-3 mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">General</p>
                <x-nav-link :href="route('branch.index')" :active="request()->routeIs('branch.*')"  class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:text-red-600 transition-colors">
                    <x-heroicon-o-building-office class="w-4 h-4 text-gray-400" /> Sucursales
                </x-nav-link>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:text-red-600 transition-colors">
                    <x-heroicon-o-credit-card class="w-4 h-4 text-gray-400" /> Métodos de pago
                </x-nav-link>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:text-red-600 transition-colors">
                    <x-heroicon-o-document-check class="w-4 h-4 text-gray-400" /> Info. Legal
                </x-nav-link>

                <p class="px-3 mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Personal</p>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:text-red-600 transition-colors">
                    <x-heroicon-o-user-group class="w-4 h-4 text-gray-400" /> Usuarios
                </x-nav-link>

                <p class="px-3 mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Comunicaciones</p>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:text-red-600 transition-colors">
                    <x-heroicon-o-envelope class="w-4 h-4 text-gray-400" /> Enviar Correo
                </x-nav-link>
                <x-nav-link href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:text-red-600 transition-colors">
                    <x-heroicon-o-speaker-wave class="w-4 h-4 text-gray-400" /> Boletines
                </x-nav-link>
            </div>
        </div>
    </nav>

    <div class="p-4 border-t border-gray-100 bg-white">
        <div class="flex items-center gap-3 px-2 py-3 mb-4 rounded-xl bg-gray-50 border border-gray-100">
            <div class="w-9 h-9 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</span>
                <span class="text-[10px] uppercase font-bold text-red-500 tracking-wider">Administrador</span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="group flex w-full items-center gap-3 px-3 py-2 text-sm font-medium text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 transition-transform group-hover:-translate-x-1" /> 
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>