<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Str;

class SubCategoryController extends Controller
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

        SubCategory::create([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'slug'          => Str::slug($request->name, '-')
        ]);

        return back()->with('success', ' Successfully!');
    }

    public function show()
    {
        $data     = SubCategory::count();
        $category = Category::orderBy('name', 'asc')->get();

        return view('pages.category.sub.show', compact('data','category'));
    }

    public function select()
    {
        $data   = SubCategory::orderBy('category_id', 'asc');
        $result = $data->get();

        $no         = 1;
        $response   = [];
        foreach ($result as $row) {
            $aksi   = '';

            $aksi .= '
                <a href="' . route('sub-category.detail', $row->id) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>

                <a href="' . route('sub-category.edit', $row->id) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                    <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'        => $no,
                'id'        => $row->id,
                'aksi'      => $aksi,
                'category'  => $row->category->name ?? '',
                'name'      => $row->name,
                'slug'      => $row->slug
            ];

            $no++;
        }
        return response()->json($response);
    }

    public function edit($id)
    {
        $data     = SubCategory::findOrFail($id);
        $category = Category::orderBy('name', 'asc')->get();

        return view('pages.category.sub.edit', compact('data', 'category'));
    }

    public function update(Request $request, $id)
    {
        $data = SubCategory::findOrFail($id);

        $request->validate([
            'slug'   => 'unique:sub_categories,slug,' . $data->id,
            'name'   => 'unique:sub_categories,name,' . $data->id,
        ]);

        $data->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name, '-')
        ]);

        return back()->with('success', ' Successfully!');
    }

    public function destroy($id)
    {
        SubCategory::findOrFail($id)->delete();

        return back()->with('success', 'Successfully!');
    }
}
