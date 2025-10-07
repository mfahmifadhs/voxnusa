<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        //
    }
    public function detail($id)
    {
        $data = Post::where('id', $id)->first();

        return view('pages.post.detail', compact('data'));
    }

    public function review($id)
    {
        $data = Post::findOrFail($id);

        if ($data->status == 'draft') {
            $data->update([
                'status' => 'review'
            ]);
        }

        return back()->with('success', 'Successfully!');
    }

    public function create()
    {
        $user     = User::get();
        $tag      = Tag::get();
        $category = SubCategory::orderBy('name', 'asc')->get();

        return view('pages.post.create', compact('user', 'tag', 'category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'title'           => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:posts,slug',
            'content'         => 'required|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $request->foto->move(public_path('dist/img/thumbnail'), $fileName);
        }

        $slug = Str::slug($validated['title']);

        $id   = Post::withTrashed()->count() + 1;
        $post = Post::create([
            'id'              => $id,
            'user_id'         => Auth::id(),
            'sub_category_id' => $validated['sub_category_id'],
            'title'           => $validated['title'],
            'slug'            => $slug,
            'content'         => $validated['content'],
            'thumbnail'       => $fileName,
            'views'           => 0
        ]);

        $post->tags()->sync($request->tags);

        return redirect()->route('post.detail', $id)->with('success', 'Successfully!');
    }

    public function show(Request $request, Post $post)
    {
        $data = Post::count();
        $category = Category::orderBy('name', 'asc')->get();
        $user     = User::orderBy('name', 'asc')->get();
        $selectCategory = $request->category_id;
        $selectUser     = $request->user_id;
        $selectStatus   = $request->status_id;
        return view('pages.post.show', compact('data', 'category', 'user', 'selectCategory', 'selectUser', 'selectStatus'));
    }

    public function select(Request $request)
    {
        $category   = $request->category;
        $user       = $request->user;
        $status     = $request->status;
        $search     = $request->search;

        $data       = Post::orderBy('status', 'desc');


        if (Auth::user()->role_id == 2) {
            $data   = $data->whereIn('status', ['draft', 'review', 'published']);
        }

        if (Auth::user()->role_id == 3) {
            $data   = $data->where('user_id', Auth::user()->id);
        }

        if ($category || $user || $status || $search) {

            if ($category) {
                $res = $data->where('category_id', $category);
            }

            if ($user) {
                $res = $data->where('user_id', $user);
            }

            if ($status) {
                $res = $data->where('status', $status);
            }

            if ($search) {
                $res = $data->where('title', 'like', '%' . $search . '%');
            }

            $result = $res->get();
        } else {
            $result = $data->get();
        }


        $no         = 1;
        $response   = [];
        foreach ($result as $row) {
            $aksi   = '';
            $status = '';
            $foto   = '';

            $aksi .= '
                    <a href="' . route('post.detail', $row->id) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                        <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                    </a>
                ';


            if ($row->status == 'draft' && in_array(Auth::user()->role_id, [1, 3])) {
                $aksi .= '
                    <a href="' . route('post.edit', $row->id) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                        <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                    </a>
                ';
            }

            if ($row->status == 'draft' || $row->status == 'review') {
                $status .= '
                    <span class="badge badge-warning">' . $row->status . '</span>
                ';
            } else {
                $status .= '
                    <span class="badge badge-success">' . $row->status . '</span>
                ';
            }

            if ($row->thumbnail) {
                $foto = "<img src='" . asset('dist/img/thumbnail/' . $row->thumbnail) . "' alt='Thumbnail' width='150'>";
            } else {
                $foto = "Tidak ada";
            }

            $response[] = [
                'no'        => $no,
                'id'        => $row->id,
                'aksi'      => $aksi,
                'user'      => $row->user->name,
                'category'  => $row->category->name,
                'title'     => $row->title,
                'slug'      => $row->slug,
                'content'   => $row->content,
                'thumbnail' => $foto,
                'published' => $row->published_at,
                'views'     => $row->views,
                'status'    => $status
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function edit($id)
    {
        $data     = Post::with('tags')->where('id', $id)->first();
        $user     = User::get();
        $tag      = Tag::get();
        $category = SubCategory::orderBy('name', 'asc')->get();

        return view('pages.post.edit', compact('data', 'user', 'tag', 'category'));
    }

    public function update(Request $request, $id)
    {
        $data = Post::findOrFail($id);

        $request->validate([
            'slug'  => 'unique:posts,slug,' . $data->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $request->foto->move(public_path('dist/img/thumbnail'), $fileName);
        }

        $data->update([
            'user_id'       => $request->user_id,
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'content'       => $request->content,
            'thumbnail'     => $fileName ?? $data->thumbnail,
            'views'         => 0
        ]);


        $data->tags()->sync($request->tags);

        return redirect()->route('post.detail', $data->id)->with('success', ' Successfully!');
    }

    public function destroy(Post $post)
    {
        //
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('posts', 'public'); // simpan ke storage/app/public/posts
            $url = asset('storage/' . $path);
            return response()->json($url);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function verif(Request $request, $id)
    {
        $data = Post::findOrFail($id);
        if ($request->status == 'published') {
            $data->update([
                'reviewer_id'  => Auth::user()->id,
                'status'       => $request->status,
                'notes'        => $request->notes,
                'published_at' => Carbon::now()
            ]);
        } else {
            $data->update([
                'reviewer_id' => Auth::user()->id,
                'status'      => $request->status,
                'notes'       => $request->notes
            ]);
        }

        return redirect()->route('post.detail', $data->id)->with('success', ' Successfully!');
    }
}
