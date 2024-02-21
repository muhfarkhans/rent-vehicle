<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = "vehicles";

    protected $fillable = [
        'vehicle_origin_id',
        'vehicle_type_id',
        'ownership',
        'name',
        'police_number',
        'fuel_type',
        'repair_date',
        'is_on_loan',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class, 'vehicle_id', 'id');
    }

    public function vehicleOrigin()
    {
        return $this->hasOne(VehicleOrigin::class, 'id', 'vehicle_origin_id');
    }

    public function vehicleType()
    {
        return $this->hasOne(VehicleType::class, 'id', 'vehicle_type_id');
    }
}
