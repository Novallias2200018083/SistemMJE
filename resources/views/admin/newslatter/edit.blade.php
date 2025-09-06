<x-admin-layout>
    <x-slot name="header">Edit Berita</x-slot>
    <x-slot name="subheader">Memperbarui berita: {{ $newslatter->title }}</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Edit Berita</h2>

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

        <form method="POST" action="{{ route('admin.newslatter.update', $newslatter->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $newslatter->title) }}"
                        required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('description', $newslatter->description) }}</textarea>
                </div>

                <!-- Link Embed -->
                <div>
                    <label for="embed_url" class="block text-sm font-medium text-gray-700">Link Embed (YouTube /
                        IG)</label>
                    <input id="embed_url" name="embed_url" type="text"
                        value="{{ old('embed_url', $newslatter->embed_url) }}"
                        placeholder="https://www.youtube.com/embed/xxx atau iframe IG"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.newslatter.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">
                    Update Berita
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
