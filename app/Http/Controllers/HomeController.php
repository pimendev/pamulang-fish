<?php

namespace App\Http\Controllers;

use App\Models\AppearanceSetting;
use App\Models\Article;
use App\Models\Category;
use App\Models\HomepageSection;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $appearance = AppearanceSetting::current();
        $sections = HomepageSection::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $featuredProducts = Product::with(['images', 'category'])
            ->where('is_featured', true)
            ->where('status', 'available')
            ->take(6)
            ->get();
        $latestArticles = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.home', compact(
            'appearance',
            'sections',
            'categories',
            'featuredProducts',
            'latestArticles'
        ));
    }
}
