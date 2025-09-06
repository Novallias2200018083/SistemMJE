<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('all')) {
            // Ambil semua berita
            $news = News::latest()->get();
        } else {
            // Default ambil 6 dulu saja
            $news = News::latest()->take(6)->get();
        }

        return view('public.newslatter', compact('news'));
    }
}
