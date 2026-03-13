<x-app-layout>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div x-data="{ openAddModal: false, openEditModal: false, editData: {} }" 
         class="py-10 bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen">
        
        <div class="max-w-6xl mx-auto px-4">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 rounded shadow-lg animate-bounce">
                    <span class="font-bold">Sukses!</span> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
    <div class="mb-4 p-2 bg-red-100 text-red-600 text-xs rounded-lg">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="h-1 w-10 bg-blue-600 rounded-full"></span>
                        <span class="text-[11px] font-extrabold text-blue-600 uppercase tracking-[0.3em]">DAFTAR PRODUK</span>
                    </div>
                    
                    <p class="text-slate-400 mt-4 text-lg font-medium">Lihat semua produk dalam satu genggaman.</p>
                </div>
                
                @if(strtolower(auth()->user()->role) == 'admin')
                    <button type="button" @click="openAddModal = true" 
                       class="bg-blue-600 text-white font-black px-8 py-3 rounded-full shadow-xl hover:bg-white hover:text-blue-600 hover:scale-105 transition-all duration-300 border-2 border-blue-600 uppercase text-sm">
                        + POSTING PRODUK
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white/70 backdrop-blur-lg border border-blue-200 p-5 rounded-3xl shadow-xl flex flex-col justify-between">
                    <p class="text-blue-500 text-[10px] font-black uppercase tracking-widest mb-2">TOTAL PRODUK</p>
                    <div class="flex items-end gap-2">
                        <span class="text-4xl font-black text-blue-900 leading-none">{{ $fotos->count() }}</span>
                        <span class="text-blue-600 text-xs font-bold uppercase mb-1">POSTINGAN</span>
                    </div>
                </div>

                <div class="bg-white/70 backdrop-blur-lg border border-blue-200 p-5 rounded-3xl shadow-xl">
                    <p class="text-blue-500 text-[10px] font-black uppercase tracking-widest mb-2">STATUS</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-black text-blue-900 uppercase">{{ auth()->user()->role }}</span>
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    </div>
                </div>

                @if(strtolower(auth()->user()->role) == 'admin')
                    <div class="bg-white/70 backdrop-blur-lg border border-blue-200 p-5 rounded-3xl shadow-xl">
                        <p class="text-blue-500 text-[10px] font-black uppercase tracking-widest mb-2">Total SUKA</p>
                        <div class="flex items-center gap-2">
                            <span class="text-3xl font-black text-blue-900 leading-none">{{ $fotos->sum('likes_count') }}</span>
                            <span class="text-2xl">❤️</span>
                        </div>
                    </div>
                    <div class="bg-white/70 backdrop-blur-lg border border-blue-200 p-5 rounded-3xl shadow-xl">
                        <p class="text-blue-500 text-[10px] font-black uppercase tracking-widest mb-2">Total KOMENTAR</p>
                        <div class="flex items-center gap-2">
                            <span class="text-3xl font-black text-blue-900 leading-none">{{ $fotos->sum('komentars_count') }}</span>
                            <span class="text-2xl">💬</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($fotos as $foto)
                    <div class="group relative bg-white border border-blue-100 rounded-[2.5rem] overflow-hidden hover:border-blue-400 transition-all duration-500 shadow-xl">
                        <div class="aspect-square overflow-hidden relative">
                            <img src="{{ asset('storage/fotos/'.$foto->LokasiFile) }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            
                            <div class="absolute inset-0 bg-white/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-6">
                                <button onclick="likeFoto(this, {{ $foto->FotoID }})" class="text-center">
                                    <span class="heart-icon text-3xl block transition-transform hover:scale-125">{{ $foto->isLikedByUser ? '❤️' : '🤍' }}</span>
                                    <span class="like-count text-blue-900 text-xs font-black">{{ $foto->likes_count }}</span>
                                </button>
                                <a href="{{ route('foto.show', $foto->FotoID) }}" class="bg-blue-600 p-4 rounded-full text-white">👁️</a>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-black text-blue-950 truncate">{{ $foto->JudulFoto }}</h3>
                            <p class="text-blue-700 text-xs italic mb-4">"{{ $foto->DeskripsiFoto }}"</p>
                            
                            <div class="flex justify-between items-center">
                                @if(strtolower(auth()->user()->role) == 'admin')
                                    <div class="flex gap-3">
                                        <button type="button" 
                                            @click="openEditModal = true; editData = { id: '{{ $foto->FotoID }}', judul: '{{ $foto->JudulFoto }}', deskripsi: '{{ $foto->DeskripsiFoto }}', album: '{{ $foto->AlbumID }}', img: '{{ asset('storage/fotos/'.$foto->LokasiFile) }}' }" 
                                            class="text-[10px] font-black uppercase text-blue-600 hover:underline">
                                            Edit
                                        </button>
                                        
                                        <form action="{{ route('foto.destroy', $foto->FotoID) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-black uppercase text-red-600" onclick="return confirm('Hapus?')">HAPUS</button>
                                        </form>
                                    </div>
                                @endif
                                <span class="text-[10px] text-blue-300 font-bold uppercase">{{ $foto->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center text-blue-500 font-black italic">GALERI KOSONG</div>
                @endforelse
            </div>
        </div>

        <div x-show="openAddModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm" @click="openAddModal = false"></div>
                
                <div class="relative bg-white w-full max-w-2xl p-8 md:p-10 rounded-[2.5rem] shadow-2xl border border-blue-200">
                    <h2 class="text-3xl font-extrabold text-blue-600 mb-6 uppercase">POSTING <span class="text-blue-900">PRODUK</span></h2>
                    
                    <form action="{{ route('foto.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-black text-xs text-blue-900 uppercase mb-2">GAMBAR</label>
                                    <input type="file" name="file" required class="w-full text-xs p-2 bg-blue-50 rounded-xl border border-blue-100">
                                </div>
                                <div>
                                    <label class="block font-black text-xs text-blue-900 uppercase mb-2">KATEGORI</label>
                                    <select name="AlbumID" required class="w-full bg-blue-50 border-blue-100 rounded-xl px-4 py-3 text-sm">
                                        <option value="" disabled selected>-- pilih kategori --</option>
                                        @foreach($albums as $album)
                                            <option value="{{ $album->AlbumID }}">{{ $album->NamaAlbum }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-black text-xs text-blue-900 uppercase mb-2">JUDUL</label>
                                    <input type="text" name="JudulFoto" required class="w-full bg-blue-50 border-blue-100 rounded-xl px-4 py-3 text-sm">
                                </div>
                                <div>
                                    <label class="block font-black text-xs text-blue-900 uppercase mb-2">DESKRIPSI</label>
                                    <textarea name="DeskripsiFoto" rows="3" class="w-full bg-blue-50 border-blue-100 rounded-xl px-4 py-3 text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 pt-6 border-t flex justify-end gap-4">
                            <button type="button" @click="openAddModal = false" class="text-blue-400 font-black text-xs uppercase">BATAL</button>
                            <button type="submit" class="bg-blue-600 text-white font-black px-8 py-3 rounded-xl uppercase text-xs shadow-lg">POSTING PRODUK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openEditModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm" @click="openEditModal = false"></div>
                
                <div class="relative bg-white w-full max-w-2xl p-8 md:p-10 rounded-[2.5rem] shadow-2xl border border-blue-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-extrabold text-blue-600 uppercase">EDIT <span class="text-blue-900">PRODUK</span></h2>
                        <span class="text-[10px] font-black text-blue-400 px-3 py-1 bg-blue-50 rounded-full" x-text="'ID: #' + editData.id"></span>
                    </div>

                    <form :action="'/foto/' + editData.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="w-full md:w-1/3 text-center">
                                <label class="block font-black text-xs text-blue-900 uppercase mb-4">GAMBAR</label>
                                <img :src="editData.img" class="w-full aspect-square object-cover rounded-3xl border-4 border-blue-500 shadow-xl rotate-2">
                            </div>
                            <div class="w-full md:w-2/3 space-y-4">
                                <div>
                                    <label class="block font-black text-xs text-blue-900 uppercase mb-2">KATEGORI</label>
                                    <select name="AlbumID" x-model="editData.album" class="w-full bg-blue-50 border-blue-100 rounded-xl px-4 py-3 text-sm font-bold">
                                        @foreach($albums as $album)
                                            <option value="{{ $album->AlbumID }}">{{ $album->NamaAlbum }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-black text-xs text-blue-900 uppercase mb-2">JUDUL</label>
                                    <input type="text" name="JudulFoto" x-model="editData.judul" class="w-full bg-blue-50 border-blue-100 rounded-xl px-4 py-3 text-sm font-bold">
                                </div>
                                <div>
                                    <label class="block font-black text-xs text-blue-900 uppercase mb-2">DESKRIPSI</label>
                                    <textarea name="DeskripsiFoto" x-model="editData.deskripsi" rows="3" class="w-full bg-blue-50 border-blue-100 rounded-xl px-4 py-3 text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 pt-6 border-t flex justify-end gap-4 items-center">
                            <button type="button" @click="openEditModal = false" class="text-blue-400 font-black text-xs uppercase">BATAL</button>
                            <button type="submit" class="bg-blue-600 text-white font-black px-10 py-3 rounded-xl shadow-lg uppercase text-xs">EDIT Postingan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function likeFoto(button, fotoId) {
            const likeCountLabel = button.querySelector('.like-count');
            const heartIcon = button.querySelector('.heart-icon');
            fetch(`/foto/${fotoId}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                likeCountLabel.innerText = data.likes_count;
                heartIcon.innerText = data.isLiked ? '❤️' : '🤍';
            });
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>