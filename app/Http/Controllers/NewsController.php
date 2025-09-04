<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(9);
        return view('public.newslatter', compact('news'));
    }

    public function show(News $news)
    {
        return view('public.newslatter', compact('news'));
    }
}
