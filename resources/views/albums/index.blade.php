<x-app-layout>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div x-data="{ 
        showAddModal: false, 
        showEditModal: false, 
        showPhotoModal: false,
        editData: { id: '', nama: '', deskripsi: '' },
        currentAlbumName: '',
        currentAlbumDesc: '',
        currentAlbumDate: '',
        currentAlbumPhotos: [] 
    }" class="py-10 bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen font-sans">

        <div class="max-w-6xl mx-auto px-4">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 rounded shadow-lg animate-bounce text-sm">
                    <span class="font-bold">Sukses!</span> {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="h-1 w-10 bg-blue-600 rounded-full"></span>
                        <span class="text-[11px] font-extrabold text-blue-600 uppercase tracking-[0.3em]">DAFTAR KATEGORI</span>
                    </div>
                    
                    <p class="text-slate-400 mt-4 text-lg font-medium">Lihat semua kategori produk dalam satu genggaman.</p>
                </div>
                
                @if(auth()->user()->role == 'admin')
                <button @click="showAddModal = true" 
                        class="bg-blue-600 text-white font-black px-8 py-3 rounded-full shadow-xl hover:bg-white hover:text-blue-600 hover:scale-105 transition-all duration-300 border-2 border-blue-600 uppercase text-sm">
                    + TAMBAH KATEGORI
                </button>
                @endif
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white/70 backdrop-blur-lg border border-blue-200 p-5 rounded-3xl shadow-xl flex flex-col justify-between">
                    <p class="text-blue-500 text-[10px] font-black uppercase tracking-widest mb-2">TOTAL KATEGORI</p>
                    <div class="flex items-end gap-2">
                        <span class="text-4xl font-black text-blue-900 leading-none">{{ $albums->count() }}</span>
                        <span class="text-blue-600 text-xs font-bold uppercase mb-1">Folder</span>
                    </div>
                </div>

                <div class="bg-white/70 backdrop-blur-lg border border-blue-200 p-5 rounded-3xl shadow-xl">
                    <p class="text-blue-500 text-[10px] font-black uppercase tracking-widest mb-2">STATUS </p>
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-black text-blue-900 uppercase">{{ auth()->user()->role }}</span>
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($albums as $album)
                <div class="group bg-white border border-blue-100 rounded-[2.5rem] overflow-hidden hover:border-blue-400 transition-all duration-500 shadow-xl flex flex-col">
                    <div class="p-8 flex-grow">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            <i class="bi bi-folder2-open text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-black text-blue-950 mb-3 uppercase tracking-tighter leading-tight">
                            {{ $album->NamaAlbum }}
                        </h3>
                        <p class="text-slate-500 text-xs font-medium leading-relaxed line-clamp-3 mb-6">
                            {{ $album->Deskripsi }}
                        </p>
                    </div>

                    <div class="px-8 pb-8 space-y-4">
                        <button @click="
                            showPhotoModal = true; 
                            currentAlbumName = '{{ $album->NamaAlbum }}';
                            currentAlbumDesc = '{{ $album->Deskripsi }}';
                            currentAlbumDate = '{{ \Carbon\Carbon::parse($album->TanggalDibuat)->format('d M Y') }}';
                            currentAlbumPhotos = {{ $album->fotos->map(fn($f) => ['judul' => $f->JudulFoto])->toJson() }};
                        " class="w-full py-4 bg-blue-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-blue-600 transition-all flex items-center justify-center gap-2">
                            Selengkapnya <i class="bi bi-arrow-right"></i>
                        </button>

                        @if(auth()->user()->role == 'admin' || auth()->id() == $album->UserID)
                        <div class="flex justify-center gap-6 pt-2">
                            <button @click="showEditModal = true; editData = { id: '{{ $album->AlbumID }}', nama: '{{ $album->NamaAlbum }}', deskripsi: '{{ $album->Deskripsi }}' }" 
                                class="text-[10px] font-black uppercase text-blue-400 hover:text-blue-600 transition-colors">
                                Edit
                            </button>
                            <form action="{{ route('albums.destroy', $album->AlbumID) }}" method="POST" onsubmit="return confirm('Hapus Kategori?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[10px] font-black uppercase text-red-400 hover:text-red-600 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div x-show="showPhotoModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div @click="showPhotoModal = false" class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm"></div>
            <div class="bg-white w-full max-w-xl p-10 rounded-[2.5rem] relative z-10 shadow-2xl border border-blue-200">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Detail Kategori</p>
                        <h3 class="text-4xl font-black text-blue-900 uppercase tracking-tighter" x-text="currentAlbumName"></h3>
                    </div>
                    <button @click="showPhotoModal = false" class="text-slate-400 hover:text-blue-600"><i class="bi bi-x-lg text-2xl"></i></button>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-2">Deskripsi</label>
                        <p class="text-sm text-slate-600 italic leading-relaxed" x-text="currentAlbumDesc"></p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 block mb-3">Daftar Produk Terkait</label>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="photo in currentAlbumPhotos">
                                <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-4 py-2 rounded-xl border border-blue-100" x-text="photo.judul"></span>
                            </template>
                        </div>
                    </div>
                </div>
                <button @click="showPhotoModal = false" class="w-full mt-10 bg-blue-900 text-white font-black py-4 rounded-2xl uppercase text-[10px] tracking-widest hover:bg-blue-600 transition-all">TUTUP</button>
            </div>
        </div>

        <div x-show="showAddModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div @click="showAddModal = false" class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm"></div>
            <div class="bg-white w-full max-w-lg p-10 rounded-[2.5rem] relative z-10 shadow-2xl border border-blue-200">
                <h2 class="text-2xl font-black text-blue-600 uppercase mb-8">TAMBAH <span class="text-blue-900">KATEGORI</span></h2>
                <form action="{{ route('albums.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block font-black text-xs text-blue-900 uppercase mb-2">Nama Kategori</label>
                        <input type="text" name="NamaAlbum" required class="w-full bg-blue-50 border-blue-100 rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-black text-xs text-blue-900 uppercase mb-2">Deskripsi</label>
                        <textarea name="Deskripsi" rows="3" class="w-full bg-blue-50 border-blue-100 rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-4 pt-4">
                        <button type="button" @click="showAddModal = false" class="text-blue-400 font-black text-xs uppercase">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white font-black px-8 py-3 rounded-xl uppercase text-xs shadow-lg">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showEditModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div @click="showEditModal = false" class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm"></div>
            <div class="bg-white w-full max-w-lg p-10 rounded-[2.5rem] relative z-10 shadow-2xl border border-blue-200">
                <h2 class="text-2xl font-black text-blue-600 uppercase mb-8">Edit <span class="text-blue-900">CATEGORI</span></h2>
                <form :action="'/albums/' + editData.id" method="POST" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label class="block font-black text-xs text-blue-900 uppercase mb-2">Nama Kategori</label>
                        <input type="text" name="NamaAlbum" x-model="editData.nama" required class="w-full bg-blue-50 border-blue-100 rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block font-black text-xs text-blue-900 uppercase mb-2">Deskripsi</label>
                        <textarea name="Deskripsi" x-model="editData.deskripsi" rows="3" class="w-full bg-blue-50 border-blue-100 rounded-xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-4 pt-4">
                        <button type="button" @click="showEditModal = false" class="text-blue-400 font-black text-xs uppercase">BATAL</button>
                        <button type="submit" class="bg-blue-900 text-white font-black px-8 py-3 rounded-xl uppercase text-xs shadow-lg">Edit Kategori</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>