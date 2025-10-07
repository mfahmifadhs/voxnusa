<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function update(Request $request, $id)
    {
        $data = Pages::findOrFail($id);

        if ($data->title == 'home-ctg') {
            $data->update([
                'category_id' => $request->category_id,
            ]);
        }

        return back()->with('success', ' Successfully!');
    }
}
