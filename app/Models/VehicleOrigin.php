<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOrigin extends Model
{
    use HasFactory;

    protected $table = "vehicle_origins";

    protected $fillable = [
        'name',
        'address',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'vehicle_origin_id', 'id');
    }
}
