<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'unique:tags,slug,',
        ]);

        Tag::create([
            'name'    => $request->name,
            'slug'    => Str::slug($request->slug, '-')
        ]);

        return back()->with('success', ' Successfully!');
    }

    public function show(Tag $tag)
    {
        $data = $tag->count();

        return view('pages.tag.show', compact('data'));
    }

    public function select()
    {
        $data   = Tag::orderBy('name');
        $result = $data->get();

        $no         = 1;
        $response   = [];
        foreach ($result as $row) {
            $aksi   = '';

            $aksi .= '
                <a href="' . route('tag.edit', $row->id) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                    <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'    => $no,
                'id'    => $row->id,
                'aksi'  => $aksi,
                'name'  => $row->name,
                'slug'  => $row->slug
            ];

            $no++;
        }
        return response()->json($response);
    }

    public function edit(Tag $tag)
    {
        $data  = $tag->first();

        return view('pages.tag.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Tag::findOrFail($id);

        $request->validate([
            'slug'   => 'unique:tags,slug,' . $data->id,
        ]);

        $data->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug, '-')
        ]);

        return back()->with('success', ' Successfully!');
    }

    public function destroy(Post $post)
    {
        //
    }
}
