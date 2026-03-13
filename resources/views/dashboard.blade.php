<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .font-syne { font-family: 'Syne', sans-serif; }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.03);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 30px 60px -15px rgba(59, 130, 246, 0.1);
        }

        .btn-action {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            position: relative;
            overflow: hidden;
        }

        .btn-action::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-action:hover::after {
            left: 100%;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-up { animation: slideUp 0.6s ease-out forwards; }
    </style>

    <div class="min-h-screen bg-[#f8fafc] font-jakarta py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-100/50 rounded-full blur-[120px] -z-10 animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-100/50 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-14 gap-8 animate-up">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="h-[2px] w-8 bg-blue-600"></span>
                        <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">DASHBOARD</span>
                    </div>
                    <h3 class="text-6xl font-black text-slate-900 tracking-tighter font-syne uppercase leading-[0.8]">
                        PRODUK <span class="text-blue-600 italic">try.</span>
                    </h3>
                    <p class="text-slate-500 mt-6 text-lg">
                        Selamat berkarya, <span class="text-slate-900 font-extrabold">{{ Auth::user()->name }}</span> 
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('foto.index') }}" class="btn-action text-white px-10 py-5 rounded-2xl font-black text-xs tracking-[0.2em] flex items-center gap-4 shadow-2xl shadow-blue-500/20 transition-all">
                        JELAJAHI SEKARANG <i class="bi bi-arrow-right-short text-2xl"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                
                <div class="glass-card p-8 rounded-[3rem] relative overflow-hidden animate-up" style="animation-delay: 0.1s">
                    <div class="relative z-10 flex items-center gap-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-rose-50 to-rose-100 text-rose-500 rounded-[2rem] flex items-center justify-center shadow-sm">
                            <i class="bi bi-heart-fill text-4xl"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Suka</p>
                            <h4 class="text-4xl font-black text-slate-900 tracking-tighter">
                                {{ \App\Models\LikeFoto::where('UserID', auth()->id())->count() }}
                            </h4>
                            <p class="text-[10px] font-bold text-rose-500 mt-1 uppercase">Total Disukai</p>
                        </div>
                    </div>
                    <i class="bi bi-heart-fill absolute -right-4 -bottom-4 text-8xl text-rose-500/5 rotate-12"></i>
                </div>

                <div class="glass-card p-8 rounded-[3rem] relative overflow-hidden animate-up" style="animation-delay: 0.2s">
                    <div class="relative z-10 flex items-center gap-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 rounded-[2rem] flex items-center justify-center shadow-sm">
                            <i class="bi bi-chat-square-text-fill text-4xl"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Komentar</p>
                            <h4 class="text-4xl font-black text-slate-900 tracking-tighter">
                                {{ \App\Models\KomentarFoto::where('UserID', auth()->id())->count() }}
                            </h4>
                            <p class="text-[10px] font-bold text-blue-600 mt-1 uppercase">Total Komentar</p>
                        </div>
                    </div>
                    <i class="bi bi-chat-left-dots-fill absolute -right-4 -bottom-4 text-8xl text-blue-500/5 -rotate-12"></i>
                </div>

                <div class="bg-slate-900 p-8 rounded-[3rem] flex flex-col justify-center items-center text-center shadow-2xl relative overflow-hidden animate-up" style="animation-delay: 0.3s">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500"></div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-3">Waktu Sistem Langsung</p>
                    <h4 id="realtime-clock" class="text-5xl font-black text-white tracking-tighter font-syne tabular-nums">
                        00:00:00
                    </h4>
                    <div class="mt-3 px-4 py-1.5 bg-white/5 rounded-full border border-white/10">
                        <p id="realtime-date" class="text-[10px] font-bold text-blue-400 uppercase tracking-widest"></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 animate-up" style="animation-delay: 0.4s">
                <div class="lg:col-span-2">
                    <div class="glass-card p-12 rounded-[4rem] min-h-[450px] flex flex-col justify-center relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-12 opacity-10 group-hover:opacity-20 transition-opacity">
                            <i class="bi bi-rocket-takeoff text-[15rem] text-blue-600"></i>
                        </div>

                        <div class="relative z-10">
                            <h3 class="text-5xl font-black text-slate-900 tracking-tighter uppercase mb-8 leading-none">
                                Bebaskan <span class="text-blue-600">Kreativitas.</span><br>
                                Bagikan <span class="italic text-slate-400">Inspirasi.</span>
                            </h3>
                            <p class="text-slate-500 max-w-md mb-12 text-lg leading-relaxed font-medium">
                                Gunakan fitur galeri untuk memantau tren visual terbaru. Dashboard Anda mensinkronisasi semua interaksi secara real-time.
                            </p>
                            <div class="flex items-center gap-8">
                                <a href="{{ route('foto.index') }}" class="group flex items-center gap-4 text-slate-900 font-black text-xs uppercase tracking-[0.3em]">
                                    <span class="w-12 h-[3px] bg-blue-600 group-hover:w-20 transition-all duration-500"></span> 
                                    TELUSURI KARYA
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-10 rounded-[3.5rem] flex flex-col">
                    <div class="flex items-center justify-between mb-10">
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                            <span class="flex h-2 w-2 rounded-full bg-blue-600 animate-ping"></span>
                            komentar terbaru
                        </h5>
                        <i class="bi bi-three-dots text-slate-300"></i>
                    </div>
                    
                    <div class="space-y-8 flex-grow">
                        @php
                            $latestComments = \App\Models\KomentarFoto::where('UserID', auth()->id())
                                                              ->with('user')
                                                              ->latest()
                                                              ->take(4)
                                                              ->get();
                        @endphp

                        @forelse($latestComments as $comment)
                            <div class="flex gap-5 items-start group">
                                <div class="w-12 h-12 bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex-shrink-0 flex items-center justify-center text-sm font-black text-slate-700 shadow-sm group-hover:from-blue-600 group-hover:to-blue-700 group-hover:text-white transition-all duration-300">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div class="border-b border-slate-100 pb-4 w-full">
                                    <p class="text-[12px] font-black text-slate-900 mb-1">{{ $comment->user->name }}</p>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed italic font-medium">"{{ $comment->IsiKomentar }}"</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <i class="bi bi-chat-left-quote text-4xl text-slate-100 mb-4 block"></i>
                                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Belum Ada Aktivitas</p>
                            </div>
                        @endforelse
                    </div>

                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('realtime-clock').textContent = `${hours}:${minutes}:${seconds}`;

            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('realtime-date').textContent = now.toLocaleDateString('id-ID', options);
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
</x-app-layout>