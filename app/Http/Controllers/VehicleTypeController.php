<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class VehicleTypeController extends Controller
{
    public function index()
    {
        return view('vehicle-type.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = VehicleType::with('vehicles')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_vehicle', function ($row) {
                    return count($row->vehicles);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('vehicle-type.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('vehicle-type.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('vehicle-type.create');
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name'),
        ];

        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        try {
            VehicleType::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('vehicle-type.create');
        }

        return redirect()->route('vehicle-type.index');
    }

    public function edit($id)
    {
        $data = VehicleType::find($id);

        return view('vehicle-type.edit', ['vehicle' => $data]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'name' => $request->input('name'),
        ];

        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        try {
            VehicleType::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('vehicle-type.edit');
        }

        return redirect()->route('vehicle-type.index');
    }

    public function delete($id)
    {
        try {
            VehicleType::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('vehicle-type.index');
        }
        return redirect()->route('vehicle-type.index');
    }
}
