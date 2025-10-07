<?php

namespace App\Http\Controllers;

use App\Models\Aadb;
use App\Models\Atk;
use App\Models\Category;
use App\Models\Pages;
use App\Models\Review;
use App\Models\Pegawai;
use App\Models\Penilaian;
use App\Models\Post;
use App\Models\User;
use App\Models\Usulan;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role     = Auth::user()->role_id;
        $pages    = Pages::get();
        $category = Category::orderBy('name', 'asc')->get();
        $posts    = Post::get();
        $users    = User::where('role_id', 3)->get();


        $visitorData = Visitor::selectRaw('
            DATE(visited_at) as real_date,
            DATE_FORMAT(visited_at, "%d %b %Y") as date,
            COUNT(*) as total
        ')
            ->groupBy('real_date', 'date')
            ->orderBy('real_date', 'DESC') // ambil dari yang terbaru dulu
            ->take(7)
            ->get()
            ->sortBy('real_date');

        if ($role == 3) {
            $data = Post::count();
            $category = Category::orderBy('name', 'asc')->get();
            $user     = User::orderBy('name', 'asc')->get();
            $selectCategory = $request->category_id;
            $selectUser     = $request->user_id;
            $selectStatus   = $request->status_id;

            return view('pages.user', compact('data', 'visitorData', 'category', 'user', 'selectCategory', 'selectUser', 'selectStatus'));
        }

        return view('pages.index', compact('users', 'pages', 'posts', 'category', 'visitorData'));
    }
}
