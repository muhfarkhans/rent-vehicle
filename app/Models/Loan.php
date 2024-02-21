<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = "loans";

    protected $fillable = [
        'vehicle_id',
        'admin_id',
        'petugas_id',
        'pegawai_id',
        'return_petugas_id',
        'fuel_cost',
        'status',
        'message',
        'return_date',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

    public function petugas()
    {
        return $this->hasOne(User::class, 'id', 'petugas_id');
    }

    public function pegawai()
    {
        return $this->hasOne(User::class, 'id', 'pegawai_id');
    }

    public function returnPetugas()
    {
        return $this->hasOne(User::class, 'id', 'return_petugas_id');
    }
}
