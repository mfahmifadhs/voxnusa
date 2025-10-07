<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
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
            'slug' => 'unique:categories,slug,',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description
        ]);

        return back()->with('success', ' Successfully!');
    }

    public function show(Category $category)
    {
        $data = $category->count();

        return view('pages.category.show', compact('data'));
    }

    public function select()
    {
        $data   = Category::orderBy('name');
        $result = $data->get();

        $no         = 1;
        $response   = [];
        foreach ($result as $row) {
            $aksi   = '';

            $aksi .= '
                <a href="' . route('category.detail', $row->id) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>

                <a href="' . route('category.edit', $row->id) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                    <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'    => $no,
                'id'    => $row->id,
                'aksi'  => $aksi,
                'name'  => $row->name,
                'slug'  => $row->slug,
                'description' => $row->description ?? ''
            ];

            $no++;
        }
        return response()->json($response);
    }

    public function edit($id)
    {
        $data  = Category::findOrFail($id);

        return view('pages.category.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Category::findOrFail($id);

        $request->validate([
            'slug'   => 'unique:categories,slug,' . $data->id,
        ]);

        $data->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description ?? ''
        ]);

        return back()->with('success', ' Successfully!');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return back()->with('success', 'Successfully!');
    }
}
