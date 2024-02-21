<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleOrigin;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class VehicleController extends Controller
{
    public $fuelTypes = [
        "Bensin",
        "Solar"
    ];

    public function index()
    {
        return view('vehicle.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = Vehicle::with(['loans', 'vehicleOrigin', 'vehicleType'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_loan', function ($row) {
                    return count($row->loans);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('vehicle.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('vehicle.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $origins = VehicleOrigin::latest()->get();
        $types = VehicleType::latest()->get();
        $fuelTypes = $this->fuelTypes;

        return view('vehicle.create', ['origins' => $origins, 'types' => $types, 'fuelTypes' => $fuelTypes]);
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'vehicle_origin_id' => $request->input('vehicle_origin_id'),
            'vehicle_type_id' => $request->input('vehicle_type_id'),
            'ownership' => $request->input('ownership'),
            'name' => $request->input('name'),
            'police_number' => $request->input('police_number'),
            'fuel_type' => $request->input('fuel_type'),
            'repair_date' => $request->input('repair_date'),
            'is_on_loan' => 0
        ];

        Validator::make($request->all(), [
            'vehicle_origin_id' => 'required',
            'vehicle_type_id' => 'required',
            'ownership' => 'required',
            'name' => 'required',
            'police_number' => 'required',
            'fuel_type' => 'required',
            'repair_date' => 'required',
        ])->validate();

        try {
            Vehicle::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('vehicle.create');
        }

        return redirect()->route('vehicle.index');
    }

    public function edit($id)
    {
        $data = Vehicle::find($id);
        $origins = VehicleOrigin::latest()->get();
        $types = VehicleType::latest()->get();
        $fuelTypes = $this->fuelTypes;

        return view('vehicle.edit', ['vehicle' => $data, 'origins' => $origins, 'types' => $types, 'fuelTypes' => $fuelTypes]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'vehicle_origin_id' => $request->input('vehicle_origin_id'),
            'vehicle_type_id' => $request->input('vehicle_type_id'),
            'ownership' => $request->input('ownership'),
            'name' => $request->input('name'),
            'police_number' => $request->input('police_number'),
            'fuel_type' => $request->input('fuel_type'),
            'repair_date' => $request->input('repair_date'),
        ];

        Validator::make($request->all(), [
            'vehicle_origin_id' => 'required',
            'vehicle_type_id' => 'required',
            'ownership' => 'required',
            'name' => 'required',
            'police_number' => 'required',
            'fuel_type' => 'required',
            'repair_date' => 'required',
        ])->validate();

        try {
            Vehicle::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('vehicle.edit');
        }

        return redirect()->route('vehicle.index');
    }

    public function delete($id)
    {
        try {
            Vehicle::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('vehicle.index');
        }
        return redirect()->route('vehicle.index');
    }
}
