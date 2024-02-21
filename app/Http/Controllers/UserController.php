<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('role')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role_name', function ($row) {
                    return $row->role->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('user.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('user.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $roles = Role::latest()->get();

        return view('user.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'password' => Hash::make($request->input('password'))
        ];

        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ])->validate();

        try {
            User::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('user.create');
        }

        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $data = User::find($id);
        $roles = Role::latest()->get();

        return view('user.edit', ['user' => $data, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
        ];

        $validationRule = [
            'name' => 'required',
            'role_id' => 'required',
            'email' => 'unique:users,email,' . $id,
        ];

        if (strlen($request->input('password')) < 8 && strlen($request->input('password')) != 0) {
            $validationRule = array_merge($validationRule, ['password' => 'min:8']);

        }
        Validator::make($request->all(), $validationRule)->validate();

        try {
            if ($request->input('password') != null) {
                $dataUpdate['password'] = Hash::make($request->input('password'));
            }

            User::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('user.edit', $id);
        }

        return redirect()->route('user.index');
    }

    public function delete($id)
    {
        try {
            User::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('user.index');
        }
        return redirect()->route('user.index');
    }
}
