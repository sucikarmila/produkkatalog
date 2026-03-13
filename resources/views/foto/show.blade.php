<x-app-layout>
    <div class="py-6 md:py-12 bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="max-w-6xl w-full mx-auto px-4">
            
            <a href="{{ route('foto.index') }}" class="inline-flex items-center text-gray-500 hover:text-black mb-4 transition-all font-semibold text-sm">
                <i class="bi bi-chevron-left mr-2"></i> Kembali
            </a>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-2xl flex flex-col lg:flex-row lg:h-[85vh]">
                
                <div class="lg:w-3/5 bg-black flex items-center justify-center relative border-r border-gray-100">
                    <img src="{{ asset('storage/fotos/'.$foto->LokasiFile) }}" 
                         class="w-full h-full object-contain" 
                         alt="{{ $foto->JudulFoto }}"
                         ondblclick="likeFoto(this, {{ $foto->FotoID }})">
                    
                    
                </div>

                <div class="lg:w-2/5 flex flex-col bg-white">
                    
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600 p-[2px]">
                                <div class="h-full w-full rounded-full bg-white p-[1px]">
                                    <div class="h-full w-full rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-700">
                                        {{ substr($foto->user->name ?? 'U', 0, 1) }}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-none">{{ $foto->user->name ?? 'User' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                        <div class="flex gap-3 mb-6">
                            
                            <div class="text-sm">
                                <p class="mb-2">
                                    <span class="font-bold mr-2">{{ $foto->user->name }}</span>
                                    <span class="text-gray-700 leading-relaxed">{{ $foto->DeskripsiFoto }}</span>
                                </p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">
                                    {{ $foto->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="border-t border-gray-50 my-4 text-center">
                            <span class="bg-white px-3 -mt-3 inline-block text-[10px] text-gray-300 font-bold uppercase tracking-widest">Komentar</span>
                        </div>

                        <div class="space-y-6">
                            @forelse($comments as $k)
                                <div class="flex gap-3 group">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-700 shrink-0">
                                        {{ substr($k->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 text-sm">
                                        <p>
                                            <span class="font-bold mr-2 text-gray-900">{{ $k->user->name }}</span>
                                            <span class="text-gray-600 leading-relaxed">{{ $k->IsiKomentar }}</span>
                                        </p>
                                        <div class="flex gap-4 mt-2 text-[10px] font-black text-gray-400 uppercase tracking-tighter">
                                            <span>{{ $k->created_at->diffForHumans(null, true) }}</span>
                                            <button onclick="siapkanBalasan('{{ $k->user->name }}', {{ $k->KomentarID }})" class="hover:text-blue-600 transition-colors">Balas</button>
                                        </div>

                                        @if($k->replies->count() > 0)
                                            <div class="mt-4 border-l-2 border-gray-100 pl-4 space-y-4">
                                                @foreach($k->replies as $balasan)
                                                    <div class="flex gap-2">
                                                        <div class="text-xs">
                                                            <span class="font-bold text-gray-900 mr-1">{{ $balasan->user->name }}</span>
                                                            <span class="text-gray-600">{{ $balasan->IsiKomentar }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10">
                                    <i class="bi bi-chat-dots text-4xl text-gray-100 block mb-2"></i>
                                    <p class="text-gray-400 text-xs italic">Belum ada diskusi di sini...</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-100 shrink-0 bg-white shadow-[0_-10px_20px_rgba(0,0,0,0.02)]">
                        <div class="flex items-center gap-4 mb-2">
                            <button onclick="likeFoto(this, {{ $foto->FotoID }})" class="hover:scale-110 transition-transform active:scale-90">
                                <span class="heart-icon text-2xl">
                                    @if($foto->isLikedByUser)
                                        <i class="bi bi-heart-fill text-red-500"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif
                                </span>
                            </button>
                            <button onclick="document.getElementById('input-komentar').focus()" class="text-2xl hover:text-gray-400 transition-colors">
                                <i class="bi bi-chat"></i>
                            </button>
                        </div>
                        
                        <p class="text-sm font-black text-gray-900 mb-3 tracking-tight">
                            <span class="like-count">{{ number_format($foto->likes_count) }}</span> suka
                        </p>

                        <div id="reply-info" class="hidden mb-3 text-[10px] bg-blue-600 text-white p-2 rounded-lg flex justify-between items-center animate-in fade-in slide-in-from-bottom-2">
                            <span><i class="bi bi-reply-fill mr-1"></i> Membalas @<span id="reply-name" class="font-black"></span></span>
                            <button onclick="batalBalas()" class="text-lg hover:text-red-200 transition-colors">&times;</button>
                        </div>

                        <form action="{{ route('komentar.store', $foto->FotoID) }}" method="POST" class="flex items-center gap-2 border-t border-gray-50 pt-3 group">
                            @csrf
                            <input type="hidden" name="parent_id" id="parent_id">
                            <input type="text" name="IsiKomentar" id="input-komentar" 
                                   placeholder="Tambahkan komentar..." required
                                   class="flex-1 border-none focus:ring-0 text-sm py-2 bg-transparent placeholder:text-gray-400">
                            <button type="submit" id="btn-submit" 
                                    class="text-blue-500 font-bold text-sm disabled:opacity-30 hover:text-blue-700 transition-all uppercase tracking-widest px-2">
                                KIRIM
                            </button>
                        </form>
                    </div>

                </div> </div>
        </div>
    </div>

    <script>
        function siapkanBalasan(nama, id) {
            document.getElementById('reply-info').classList.remove('hidden');
            document.getElementById('reply-name').innerText = nama;
            document.getElementById('parent_id').value = id;
            document.getElementById('input-komentar').focus();
            document.getElementById('input-komentar').placeholder = "Membalas " + nama + "...";
        }

        function batalBalas() {
            document.getElementById('reply-info').classList.add('hidden');
            document.getElementById('parent_id').value = '';
            document.getElementById('input-komentar').placeholder = "Tambahkan komentar...";
        }

        function likeFoto(element, fotoId) {
            fetch(`/foto/${fotoId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('.like-count').forEach(el => el.innerText = data.likes_count.toLocaleString());
                
                document.querySelectorAll('.heart-icon').forEach(el => {
                    el.innerHTML = data.isLiked 
                        ? '<i class="bi bi-heart-fill text-red-500 animate-heart-beat"></i>' 
                        : '<i class="bi bi-heart"></i>';
                });
            })
            .catch(error => console.error('Error:', error));
        }

        const input = document.getElementById('input-komentar');
        const btn = document.getElementById('btn-submit');
        input.addEventListener('input', () => {
            btn.disabled = !input.value.trim();
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
        
        @keyframes heart-beat {
            0% { transform: scale(1); }
            15% { transform: scale(1.3); }
            30% { transform: scale(1); }
            45% { transform: scale(1.15); }
            60% { transform: scale(1); }
        }
        .animate-heart-beat { 
            display: inline-block;
            animation: heart-beat 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
        }

        input:focus { outline: none !important; box-shadow: none !important; }
        
        /* Mengunci tinggi container di desktop agar scrollable sisi kanan bekerja */
        @media (min-width: 1024px) {
            .lg\:h-\[85vh\] { height: 85vh; }
        }
    </style>
</x-app-layout>