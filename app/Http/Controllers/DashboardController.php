<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $vehicleAvailable = Vehicle::where('is_on_loan', 0)->get();
        $vehicleNotAvailable = Vehicle::where('is_on_loan', 1)->get();
        $loan = Loan::get();
        $status1 = Loan::where('status', 1)->get();
        $status2 = Loan::where('status', 2)->get();
        $status3 = Loan::where('status', 3)->get();
        $status4 = Loan::where('status', 4)->get();
        $pegawai = User::where('role_id', 3)->get();

        return view('dashboard', [
            'vehicleAvailable' => count($vehicleAvailable),
            'vehicleNotAvailable' => count($vehicleNotAvailable),
            'loan' => count($loan),
            'pegawai' => count($pegawai),
            'status1' => count($status1),
            'status2' => count($status2),
            'status3' => count($status3),
            'status4' => count($status4),
        ]);
    }
}
