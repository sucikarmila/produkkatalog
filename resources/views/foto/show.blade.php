<x-app-layout>
    <div class="py-10 bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4">
            
            <a href="{{ route('foto.index') }}" class="group inline-flex items-center text-blue-600 hover:text-blue-800 mb-6 transition-all font-black uppercase tracking-widest text-xs drop-shadow-sm">
                <span class="mr-2 group-hover:-translate-x-2 transition-transform">←</span> KEMBALI
            </a>

            <div class="bg-white rounded-[3rem] overflow-hidden shadow-2xl border border-blue-100 flex flex-col lg:flex-row min-h-[80vh]">
                
                <div class="lg:w-2/3 bg-slate-50 flex items-center justify-center p-4 md:p-10 relative">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#2563eb 0.5px, transparent 0.5px); background-size: 20px 20px;"></div>
                    
                    <img src="{{ asset('storage/fotos/'.$foto->LokasiFile) }}" 
                         class="relative z-10 max-w-full max-h-[70vh] object-contain rounded-xl shadow-2xl border border-white" 
                         alt="{{ $foto->JudulFoto }}">
                </div>

                <div class="lg:w-1/3 flex flex-col bg-white h-[80vh]">
                    
                    <div class="p-8 pb-4 shrink-0">
                        <h2 class="text-3xl font-black text-blue-900 leading-tight uppercase tracking-tighter">
                            {{ $foto->JudulFoto }}
                        </h2>
                        <div class="flex items-center gap-2 mt-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                            <span class="bg-blue-50 px-2 py-1 rounded flex items-center gap-1">
                                <i class="bi bi-calendar3"></i> {{ $foto->created_at->format('d M Y') }}
                            </span>
                            <span class="bg-gray-100 px-2 py-1 rounded text-gray-500 text-[9px]">By: {{ $foto->user->name ?? 'User' }}</span>
                        </div>
                        <p class="text-gray-500 mt-4 italic text-sm leading-relaxed border-l-4 border-blue-500 pl-4">
                            "{{ $foto->DeskripsiFoto }}"
                        </p>
                    </div>

                    <div class="px-8 shrink-0">
                        <div class="flex items-center justify-between py-4 border-y border-gray-100">
                            <button type="button" onclick="likeFoto(this, {{ $foto->FotoID }})" class="flex items-center gap-3 group">
                                <span class="heart-icon text-3xl group-active:scale-150 transition-transform duration-200">
                                    {{ $foto->isLikedByUser ? '❤️' : '🤍' }}
                                </span>
                                <div class="flex flex-col items-start">
                                    <span class="like-count font-black text-lg text-red-600 leading-none">{{ $foto->likes_count }}</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">SUKA</span>
                                </div>
                            </button>

                            <div class="flex flex-col items-end">
                                <span class="font-black text-lg text-blue-900 leading-none">{{ $foto->komentars_count }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">KOMEN</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-8 pt-6 custom-scrollbar space-y-6 bg-blue-50/30">
                        @forelse($comments as $k)
                            <div class="flex flex-col gap-3">
                                <div class="flex gap-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-xs font-black text-white border-2 border-white shrink-0 shadow-md">
                                        {{ substr($k->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-blue-50 relative">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-[10px] font-black text-blue-900 uppercase">{{ $k->user->name }}</span>
                                                <span class="text-[9px] text-gray-400 font-bold">{{ $k->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $k->IsiKomentar }}</p>
                                        </div>
                                        
                                        <div class="flex gap-4 mt-2 ml-2">
                                            <button onclick="siapkanBalasan('{{ $k->user->name }}', {{ $k->KomentarID }})" 
                                                    class="text-[9px] font-black text-blue-500 uppercase tracking-widest hover:text-blue-800 transition-all flex items-center gap-1">
                                                <i class="bi bi-reply-fill"></i> Balas
                                            </button>
                                            @if($k->replies->count() > 0)
                                                <button onclick="toggleBalasan({{ $k->KomentarID }})" 
                                                        class="text-[9px] font-black text-gray-400 uppercase tracking-widest hover:text-blue-600 transition-all flex items-center gap-1">
                                                    <i class="bi bi-eye"></i> <span id="btn-text-{{ $k->KomentarID }}">Lihat {{ $k->replies->count() }} Balasan</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div id="replies-{{ $k->KomentarID }}" class="hidden ml-12 space-y-3 border-l-2 border-blue-200 pl-4 animate-fade-in">
                                    @foreach($k->replies as $balasan)
                                        <div class="flex gap-2">
                                            <div class="h-7 w-7 rounded-full bg-blue-400 flex items-center justify-center text-[9px] font-black text-white shrink-0 shadow-sm">
                                                {{ substr($balasan->user->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1 bg-white rounded-xl p-3 border border-blue-100">
                                                <p class="text-[9px] font-black text-blue-700 uppercase mb-0.5">{{ $balasan->user->name }}</p>
                                                <p class="text-xs text-gray-800">{{ $balasan->IsiKomentar }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-400 italic text-[10px] uppercase tracking-widest font-black">No discussion yet...</p>
                            </div>
                        @endforelse
                    </div>

                   <div class="p-6 bg-white border-t border-gray-100 shrink-0">
    <div id="reply-info" class="hidden mb-3 text-[10px] text-white font-black bg-blue-900 p-3 rounded-xl flex justify-between items-center animate-fade-in uppercase tracking-wider shadow-md">
        <span><i class="bi bi-reply-all-fill mr-1"></i> Membalas: <span id="reply-name" class="text-blue-300"></span></span>
        <button onclick="batalBalas()" class="text-lg hover:text-red-400 transition-colors leading-none">&times;</button>
    </div>

    <form action="{{ route('komentar.store', $foto->FotoID) }}" method="POST" class="relative group/form">
        @csrf
        <input type="hidden" name="parent_id" id="parent_id">
        
        <textarea name="IsiKomentar" id="input-komentar" rows="2" placeholder="Tulis komentar..." required
                  class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-4 pr-16 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all resize-none shadow-inner placeholder:text-gray-400"></textarea>
        
        <button type="submit" 
                class="absolute bottom-3 right-3 bg-blue-600 text-white p-3 rounded-xl hover:bg-blue-700 active:scale-90 transition-all shadow-lg hover:shadow-blue-500/30 group">
            <i class="bi bi-send-fill text-lg group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300 inline-block"></i>
        </button>
    </form>
</div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBalasan(id) {
            const area = document.getElementById('replies-' + id);
            const text = document.getElementById('btn-text-' + id);
            area.classList.toggle('hidden');
            text.innerText = area.classList.contains('hidden') ? `Lihat ${area.children.length} Balasan` : 'Sembunyikan Balasan';
        }

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
            document.getElementById('input-komentar').placeholder = "Tulis komentar...";
        }

        function likeFoto(button, fotoId) {
            const likeCountLabel = button.querySelector('.like-count');
            const heartIcon = button.querySelector('.heart-icon');

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
                likeCountLabel.innerText = data.likes_count;
                heartIcon.innerText = data.isLiked ? '❤️' : '🤍';
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2563eb; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        
        .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(5px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
    </style>
</x-app-layout>