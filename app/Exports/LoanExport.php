<?php

namespace App\Exports;

use App\Models\Loan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoanExport implements FromView
{
    public $startDate;
    public $endDate;
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        if ($this->startDate != null && $this->endDate != null) {
            $loans = Loan::with(['vehicle', 'vehicle.vehicleOrigin', 'vehicle.vehicleType', 'admin', 'petugas', 'pegawai', 'returnPetugas'])
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->get();
        } else {
            $loans = Loan::with(['vehicle', 'vehicle.vehicleOrigin', 'vehicle.vehicleType', 'admin', 'petugas', 'pegawai', 'returnPetugas'])->get();
        }

        return view('exports.loan', [
            'loans' => $loans
        ]);
    }
}
