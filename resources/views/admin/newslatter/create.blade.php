<x-admin-layout>
    <x-slot name="header">Tambah Berita</x-slot>
    <x-slot name="subheader">Menambahkan berita baru ke portal</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
        <div class="flex items-start space-x-4 mb-8">
            <div class="bg-sky-100 text-sky-600 p-4 rounded-xl">
                <i class="fa-solid fa-newspaper fa-2x"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Form Tambah Berita</h2>
                <p class="text-gray-600 mt-1">Isi detail berita di bawah ini untuk menambahkannya ke portal.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.newslatter.store') }}">
            @csrf
            <div class="space-y-6">
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-heading text-gray-400"></i>
                        </div>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required
                            class="block w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">{{ old('description') }}</textarea>
                </div>

                <!-- Link / Embed Code -->
                <div>
                    <label for="embed_url" class="block text-sm font-medium text-gray-700">Embed Code (YouTube /
                        Instagram)</label>
                    <textarea id="embed_url" name="embed_url" rows="5" placeholder="<iframe ...> atau <blockquote ...></blockquote>"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500">{{ old('embed_url') }}</textarea>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.newslatter.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">Simpan
                    Berita</button>
            </div>
        </form>
    </div>
</x-admin-layout>
