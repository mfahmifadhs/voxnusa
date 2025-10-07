<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pages;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $category    = Category::get();
        $subCategory = SubCategory::get();
        $pages       = Pages::get();
        $posts       = Post::where('status', 'published')->get();
        $tags        = Tag::get();


        $ip  = request()->ip();
        $now = Carbon::now();

        $lastVisit = Visitor::where('ip_address', $ip)
            ->latest('visited_at')
            ->first();

        if ($lastVisit) {
            $lastTime  = Carbon::parse($lastVisit->visited_at);

            if ($lastTime->diffInMinutes($now) >= 60) {
                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => request()->header('User-Agent'),
                    'url' => request()->fullUrl(),
                ]);
            }
        }


        return view('welcome', compact('posts', 'category', 'subCategory', 'pages', 'tags'));
    }

    public function detail($slug)
    {
        $category = Category::get();
        $tags     = Tag::get();
        $posts    = Post::where('status', 'published')->get();
        $data     = Post::where('slug', $slug)->first();

        return view('detail', compact('category', 'tags', 'posts', 'data'));
    }

    public function category($id)
    {
        $category    = Category::get();
        $subCategory = SubCategory::get();
        $tags        = Tag::get();
        $posts       = Post::where('status', 'published')->get();

        $data        = Category::where('slug', $id)->first();
        $postQuery   = Post::with('subCategory')
            ->whereHas('subCategory', function ($q) use ($data) {
                $q->where('category_id', $data->id);
            })->where('status', 'published');

        $postData   = $postQuery->get();
        $postPage   = $postQuery->paginate(12);

        return view('category', compact('data', 'posts', 'postData', 'postPage', 'category', 'subCategory', 'tags'));
    }

    public function posts(Request $request)
    {
        $search      = $request->search;
        $category    = Category::get();
        $subCategory = SubCategory::get();
        $tags        = Tag::get();
        $posts       = Post::where('status', 'published')->get();

        $data = Post::orderBy('published_at', 'desc');

        if ($request->search) {
            $data = Post::where('title', 'like', '%' . $request->search . '%')->paginate(12);
        } else {
            $data = Post::paginate(12);
        }

        return view('posts', compact('data', 'posts', 'category', 'subCategory', 'tags', 'search'));
    }
}
