<nav x-data="{ open: false }" class="bg-black/80 backdrop-blur-md border-b border-white/5 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-4">
                    <div class="relative">
                        <div class="bg-white p-2 rounded-sm transform transition-all duration-500 group-hover:rotate-[360deg] group-hover:scale-110">
                            <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="absolute inset-0 bg-white/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <span class="text-white font-light tracking-[0.4em] text-lg uppercase transition-all group-hover:tracking-[0.5em]">
                        PRODUK<span class="font-black text-indigo-500">TRY</span>
                    </span>
                </a>
            </div>

            <div class="hidden space-x-10 sm:flex sm:items-center">
                @php $navItems = [['name' => 'BERANDA', 'route' => 'dashboard'], ['name' => 'KATEGORI', 'route' => 'albums.index'], ['name' => 'PRODUK', 'route' => 'foto.index']]; @endphp

                @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" 
                   class="relative group py-2 text-[11px] font-bold tracking-[0.2em] {{ request()->routeIs($item['route']) ? 'text-white' : 'text-white/40' }} hover:text-white transition-colors duration-300">
                    {{ $item['name'] }}
                    <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-indigo-500 transition-all duration-300 group-hover:w-full {{ request()->routeIs($item['route']) ? 'w-full' : '' }}"></span>
                </a>
                @endforeach
            </div>

            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-4 py-2 border border-white/10 rounded-full hover:bg-white/5 transition-all duration-300 group">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-[10px] font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-white/70 group-hover:text-white text-[10px] font-bold tracking-widest uppercase transition-colors">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-white/30 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#111] border border-white/10 p-2 space-y-1 shadow-2xl">
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="rounded hover:bg-red-500/10 !text-red-500/70 hover:!text-red-500 text-[10px] uppercase tracking-widest" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('KELUAR') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-white/70 hover:text-white transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8h16M4 16h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>