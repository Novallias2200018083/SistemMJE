<x-admin-layout>
    <x-slot name="header">Manajemen Berita</x-slot>
    <x-slot name="subheader">Kelola postingan berita portal</x-slot>

    <!-- Header & Tombol Aksi -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Berita</h2>
            <p class="text-gray-500">Kelola berita yang ditampilkan di portal</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.newslatter.create') }}"
                class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">
                <i class="fa-solid fa-plus mr-2"></i>Tambah Berita
            </a>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Berita -->
        <div class="space-y-4">
            @forelse($newslatter as $item)
                <div
                    class="bg-white border rounded-lg p-4 flex flex-wrap items-center justify-between gap-4 hover:bg-gray-50">
                    <div class="flex items-start space-x-4">
                        <div class="w-24 h-16 flex-shrink-0 overflow-hidden rounded">
                            @if (Str::contains($item->image_url, 'instagram.com'))
                                {{-- kalau link Instagram, tampilkan embed --}}
                                <blockquote class="instagram-media" data-instgrm-permalink="{{ $item->image_url }}"
                                    data-instgrm-version="14"
                                    style="background:#FFF; border:0; border-radius:3px; margin:1px; max-width:540px; min-width:326px; padding:0; width:100%;">
                                </blockquote>
                            @elseif ($item->image_url)
                                {{-- kalau link gambar biasa --}}
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                {{-- fallback kalau gak ada --}}
                                <div class="bg-gray-200 w-full h-full flex items-center justify-center text-gray-400">
                                    No Img
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ $item->title }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($item->description, 100) }}</p>
                            <p class="text-xs text-gray-400 mt-1">Diposting:
                                {{ $item->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2 flex-shrink-0">
                        <a href="{{ route('admin.newslatter.edit', $item->id) }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 text-sm hover:bg-gray-100">
                            <i class="fa-solid fa-pencil mr-2"></i>Edit
                        </a>
                        <form action="{{ route('admin.newslatter.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 border border-red-300 rounded-lg font-semibold text-red-700 text-sm hover:bg-red-50">
                                <i class="fa-solid fa-trash mr-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <i class="fa-solid fa-newspaper fa-3x mb-4"></i>
                    <p>Belum ada berita yang ditambahkan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">{{ $newslatter->links() }}</div>
    </div>
</x-admin-layout>
