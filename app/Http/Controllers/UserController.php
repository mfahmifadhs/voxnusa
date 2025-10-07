<?php

namespace App\Http\Controllers;

use App\Models\PegawaiJabatan;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hash;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $data    = User::count();
        $role    = Role::get();
        $status  = $request->status;

        $selectRole     = $request->role;
        $selectStatus   = $request->status_id;

        return view('pages.users.show', compact('role','data','status','selectRole','selectStatus'));
    }

    public function detail($id)
    {
        $data = User::where('id', $id)->first();

        return view('pages.users.detail', compact('data'));
    }

    public function select(Request $request)
    {
        $role   = $request->role;
        $status = $request->status;
        $search = $request->search;

        $data       = User::orderBy('status', 'desc');

        if ($role || $status || $search) {

            if ($role) {
                $res = $data->where('role_id', $role);
            }

            if ($status) {
                $res = $data->where('status', $status);
            }

            if ($search) {
                $res = $data->where('name', 'like', '%' . $search . '%');
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

            $aksi .= '
                <a href="' . route('users.detail', $row->id) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>

                <a href="' . route('users.edit', $row->id) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                    <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'         => $no,
                'id'         => $row->id,
                'aksi'       => $aksi,
                'role'       => $row->role->name,
                'name'       => $row->name,
                'username'   => $row->username,
                'status'     => $row->status
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id'   => 'required',
            'username'  => 'unique:users',
            'status'    => 'required',
        ]);

        $id   = User::withTrashed()->count() + 1;

        User::create([
            'id'            => $id,
            'role_id'       => $request->role_id,
            'name'          => $request->name,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'password_text' => $request->password,
            'status'        => $request->status
        ]);

        return redirect()->route('users.show')->with('success', 'Berhasil Menambahkan');
    }

    public function edit($id)
    {
        $data  = User::where('id', $id)->first();
        $role  = Role::get();
        return view('pages.users.edit', compact('data','role'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username'   => 'unique:users,username,' . $user->id,
        ]);

        $user->update([
            'role_id'       => $request->role_id,
            'name'          => $request->name,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'password_text' => $request->password,
            'status'        => $request->status
        ]);

        return redirect()->route('users.detail', $id)->with('success', ' Berhasil Menyimpan');
    }
}
