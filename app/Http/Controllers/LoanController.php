<?php

namespace App\Http\Controllers;

use App\Exports\LoanExport;
use App\Models\Loan;
use Auth;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleOrigin;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Yajra\DataTables\DataTables;

class LoanController extends Controller
{
    public $statusMessage = [
        "Data peminjaman dibuat",
        "Menunggu persetujuan",
        "Kendaraan sedang digunakan",
        "Kendaraan telah dikembalikan",
        "Pengajuan peminjaman ditolak"
    ];

    public function changeStatus($id, $statusTo = 0): void
    {
        if ($statusTo < 5) {
            $dataUpdate = [
                'status' => $statusTo,
                'message' => $this->statusMessage[$statusTo]
            ];

            try {
                Loan::where('id', $id)->update($dataUpdate);

                $loan = Loan::where('id', $id)->first();

                if ($statusTo == 3) {
                    Vehicle::where('id', $loan->vehicle_id)->update(['is_on_loan' => 0]);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

    }

    public function index()
    {
        return view('loan.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth()->user();
            $data = Loan::with(['vehicle', 'admin', 'petugas', 'pegawai', 'returnPetugas'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($auth) {
                    $actionBtn = '<div class="d-flex gap-1">';

                    if ($row->status == 1) {
                        $actionBtn .= '<a href="' . route('loan.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>';
                    }

                    if ($auth->role_id == 1 && !in_array($row->status, [2, 3, 4])) {
                        if ($row->admin_id) {
                            $actionBtn .= '<a href="' . route('loan.unapprove', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Batal Setujui Admin</a>';
                        } else {
                            $actionBtn .= '<a href="' . route('loan.approve', ['id' => $row->id]) . '" class="delete btn btn-info btn-sm">Setujui Admin</a>';
                        }
                    }

                    if ($auth->role_id == 2 && !in_array($row->status, [2, 3, 4])) {
                        if ($row->petugas_id) {
                            $actionBtn .= '<a href="' . route('loan.unapprove', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Batal Setujui Petugas</a>';
                        } else {
                            $actionBtn .= '<a href="' . route('loan.approve', ['id' => $row->id]) . '" class="delete btn btn-info btn-sm">Setujui Petugas</a>';
                        }
                    }

                    if ($row->status == 1) {
                        $actionBtn .= '<a href="' . route('loan.decline', ['id' => $row->id]) . '" class="delete btn btn-warning btn-sm">Tolak pengajuan</a>';
                    }

                    if ($row->status == 2) {
                        $actionBtn .= '<a href="' . route('loan.return-back', ['id' => $row->id]) . '" class="delete btn btn-primary btn-sm">Kembalikan</a>';
                    }


                    $actionBtn .= '<a href="' . route('loan.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a></div>';
                    return $actionBtn;
                })
                ->addColumn('message_text', function ($row) {
                    if ($row->status == 1) {
                        $text = $row->message;
                        if ($row->admin_id == null) {
                            $text .= " (Admin)";
                        }

                        if ($row->petugas_id == null) {
                            $text .= " (Petugas)";
                        }

                        return $text;
                    }

                    return $row->message;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $vehicles = Vehicle::where('is_on_loan', 0)->latest()->get();
        $users = User::where('role_id', 3)->latest()->get();

        return view('loan.create', ['vehicles' => $vehicles, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $vehicle = Vehicle::find($request->input('vehicle_id'));
        if ($vehicle->is_on_loan == 1) {
            return redirect()->route('loan.create')->with('error', "Kendaraan sedang digunakan");
        }

        $admin = Auth::user();

        $dataCreate = [
            'vehicle_id' => $request->input('vehicle_id'),
            'pegawai_id' => $request->input('pegawai_id'),
            'admin_id' => $admin->id,
            'fuel_cost' => 0,
            'status' => 1,
            'message' => "Menunggu persetujuan",
        ];

        Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'pegawai_id' => 'required',
        ])->validate();

        try {
            Loan::create($dataCreate);
            Vehicle::where('id', $dataCreate['vehicle_id'])->update(['is_on_loan' => 1]);
        } catch (\Throwable $th) {
            return redirect()->route('loan.create')->with('error', $th->getMessage());
        }

        return redirect()->route('loan.index');
    }

    public function edit($id)
    {
        $vehicles = Vehicle::where('is_on_loan', 0)->latest()->get();
        $users = User::latest()->get();

        return view('loan.edit', ['vehicles' => $vehicles, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($request->input('vehicle_id'));
        if ($vehicle->is_on_loan == 1) {
            return redirect()->route('loan.create')->with('error', "Kendaraan sedang digunakan");
        }

        $admin = Auth::user();

        $dataUpdate = [
            'vehicle_id' => $request->input('vehicle_id'),
            'pegawai_id' => $request->input('pegawai_id'),
            'admin_id' => $admin->id,
            'fuel_cost' => 0,
            'status' => 1,
            'message' => "Menunggu persetujuan",
        ];

        Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'pegawai_id' => 'required',
        ])->validate();

        try {
            Loan::where('id', $id)->update($dataUpdate);
            Vehicle::where('id', $dataUpdate['vehicle_id'])->update(['is_on_loan' => 1]);
        } catch (\Throwable $th) {
            return redirect()->route('loan.edit');
        }

        return redirect()->route('loan.index');
    }

    public function delete($id)
    {
        try {
            Loan::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('loan.index');
        }
        return redirect()->route('loan.index');
    }

    public function approve($id)
    {
        $auth = Auth::user();
        $roleName = "admin_id";

        if ($auth->role_id == 2) {
            $roleName = "petugas_id";
        }

        $dataUpdate = [
            $roleName => $auth->id
        ];

        try {
            Loan::where('id', $id)->update($dataUpdate);

            $loan = Loan::where('id', $id)->first();
            if ($loan->admin_id != null && $loan->petugas_id != null && $loan->status == 1) {
                $this->changeStatus($id, 2);
            }
        } catch (\Throwable $th) {
            return redirect()->route('loan.edit');
        }

        return redirect()->route('loan.index');
    }

    public function unApprove($id)
    {
        $auth = Auth::user();
        $roleName = "admin_id";

        if ($auth->role_id == 2) {
            $roleName = "petugas_id";
        }

        $dataUpdate = [
            $roleName => null
        ];

        try {
            Loan::where('id', $id)->update($dataUpdate);

            $loan = Loan::where('id', $id)->first();
            if ($loan->admin_id != null && $loan->petugas_id != null && $loan->status == 1) {
                $this->changeStatus($id, 2);
            }
        } catch (\Throwable $th) {
            return redirect()->route('loan.edit');
        }

        return redirect()->route('loan.index');
    }

    public function decline($id)
    {
        try {
            $this->changeStatus($id, 4);
            $loan = Loan::where('id', $id)->first();
            Vehicle::where('id', $loan->vehicle_id)->update(['is_on_loan' => 0]);
        } catch (\Throwable $th) {
            return redirect()->route('loan.edit');
        }

        return redirect()->route('loan.index');
    }

    public function returnBack($id)
    {
        $loan = Loan::with(['vehicle', 'vehicle.vehicleOrigin', 'vehicle.vehicleType', 'admin', 'petugas', 'pegawai', 'returnPetugas'])->where('id', $id)->first();

        return view('loan.return', ['loan' => $loan]);
    }

    public function returnBackStore(Request $request, $id)
    {
        $dataUpdate = [
            'fuel_cost' => $request->input('fuel_cost'),
            'return_date' => now()
        ];

        Validator::make($request->all(), [
            'fuel_cost' => 'required',
        ])->validate();

        try {
            Loan::where('id', $id)->update($dataUpdate);
            $this->changeStatus($id, 3);
        } catch (\Throwable $th) {
            return redirect()->route('loan.edit');
        }

        return redirect()->route('loan.index');
    }

    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $nameDate = "-" . $startDate . "-" . $endDate;

        return Excel::download(new LoanExport($startDate, $endDate), 'data-peminjaman' . $nameDate . '.xlsx');
    }
}
