<?php

namespace App\Http\Controllers;

use App\Models\VehicleOrigin;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class VehicleOriginController extends Controller
{
    public function index()
    {
        return view('vehicle-origin.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = VehicleOrigin::with('vehicles')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_vehicle', function ($row) {
                    return count($row->vehicles);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('vehicle-origin.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('vehicle-origin.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('vehicle-origin.create');
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ];

        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ])->validate();

        try {
            VehicleOrigin::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('vehicle-origin.create');
        }

        return redirect()->route('vehicle-origin.index');
    }

    public function edit($id)
    {
        $data = VehicleOrigin::find($id);

        return view('vehicle-origin.edit', ['vehicle' => $data]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ];

        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ])->validate();

        try {
            VehicleOrigin::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('vehicle-origin.edit');
        }

        return redirect()->route('vehicle-origin.index');
    }

    public function delete($id)
    {
        try {
            VehicleOrigin::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('vehicle-origin.index');
        }
        return redirect()->route('vehicle-origin.index');
    }
}
