<x-guest-layout>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .font-syne { font-family: 'Syne', sans-serif; }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        @keyframes slowZoom { 
            0% { transform: scale(1); } 
            100% { transform: scale(1.1); } 
        }
        .animate-slow-zoom { animation: slowZoom 25s infinite alternate ease-in-out; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .animate-float { animation: float 5s infinite ease-in-out; }

        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.15);
        }

        .product-tag {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
    </style>

    <div class="relative flex items-center justify-center min-h-screen font-jakarta overflow-hidden bg-slate-100">
        
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?q=80&w=2000" 
                 class="absolute inset-0 w-full h-full object-cover animate-slow-zoom brightness-[0.85]" 
                 alt="Modern Warehouse">
            <div class="absolute inset-0 bg-gradient-to-tr from-slate-900/40 via-blue-900/20 to-transparent z-10"></div>
        </div>

        <div class="absolute top-10 right-20 z-20 hidden lg:block animate-float" style="animation-delay: 0s;">
            <div class="bg-white/90 p-4 rounded-2xl shadow-xl border border-white/50 backdrop-blur-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                        <i class="bi bi-person-plus text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">New Account</p>
                        <p class="text-xs font-black text-slate-800">Registration Process</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative w-full max-w-[550px] p-6 z-30 my-10">
            <div class="glass-card rounded-[3rem] p-8 sm:p-12 transition-all duration-500 hover:shadow-2xl">
                
                <div class="text-center mb-8">
                    <div class="inline-flex items-center gap-2 mb-4 px-4 py-2 bg-slate-900 rounded-2xl shadow-lg">
                        <i class="bi bi-box-fill text-blue-400 text-lg"></i>
                        <span class="text-sm font-black text-white tracking-tighter">PRODUCT<span class="text-blue-400">TRY</span></span>
                    </div>
                    
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Buat Akun Baru</h2>
                    <p class="text-slate-500 text-sm mt-2 font-medium">Mulai manajemen barang Anda hari ini.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <i class="bi bi-person absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                                placeholder="Masukkan Nama Lengkap.."
                                class="w-full bg-white/60 border-2 border-transparent rounded-2xl py-3.5 pl-14 pr-6 text-slate-900 outline-none focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/5 transition-all font-medium text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
                        <div class="relative group">
                            <i class="bi bi-at absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <input id="username" type="text" name="username" :value="old('username')" required 
                                placeholder="Masukkan Nama Sebutan.."
                                class="w-full bg-white/60 border-2 border-transparent rounded-2xl py-3.5 pl-14 pr-6 text-slate-900 outline-none focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/5 transition-all font-medium text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                        <div class="relative group">
                            <i class="bi bi-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                            <input id="email" type="email" name="email" :value="old('email')" required 
                                placeholder="Masukkan Email Anda.."
                                class="w-full bg-white/60 border-2 border-transparent rounded-2xl py-3.5 pl-14 pr-6 text-slate-900 outline-none focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/5 transition-all font-medium text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kata Sandi</label>
                            <div class="relative group">
                                <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <input id="password" type="password" name="password" required 
                                    placeholder="••••••••"
                                    class="w-full bg-white/60 border-2 border-transparent rounded-2xl py-3.5 pl-12 pr-4 text-slate-900 outline-none focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/5 transition-all font-medium text-sm">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi</label>
                            <div class="relative group">
                                <i class="bi bi-shield-check absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
                                <input id="password_confirmation" type="password" name="password_confirmation" required 
                                    placeholder="••••••••"
                                    class="w-full bg-white/60 border-2 border-transparent rounded-2xl py-3.5 pl-12 pr-4 text-slate-900 outline-none focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/5 transition-all font-medium text-sm">
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="col-span-2 mt-1 text-xs text-red-500" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full h-14 product-tag hover:opacity-90 text-white font-black rounded-2xl shadow-lg shadow-blue-500/30 transition-all duration-300 flex items-center justify-center gap-3 transform hover:-translate-y-1">
                            <span class="tracking-widest text-[11px]">DAFTAR SEKARANG</span>
                            <i class="bi bi-arrow-right-short text-2xl"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center border-t border-slate-200/50 pt-6">
                    <p class="text-xs text-slate-500 font-semibold">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-black ml-1 uppercase tracking-tighter text-[11px]">Login Di Sini</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-guest-layout>