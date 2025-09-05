<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $newslatter = News::latest()->paginate(10);
        return view('admin.newslatter.index', compact('newslatter'));
    }

    public function create()
    {
        return view('admin.newslatter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'embed_url' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        News::create($request->all());

        return redirect()->route('admin.newslatter.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $newslatter)
    {
        return view('admin.newslatter.edit', compact('newslatter'));
    }

    public function update(Request $request, News $newslatter)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'embed_url' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $newslatter->update($request->all());

        return redirect()->route('admin.newslatter.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $newslatter)
    {
        $newslatter->delete();
        return redirect()->route('admin.newslatter.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
