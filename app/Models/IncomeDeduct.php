<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\AssessableType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomeDeduct extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit_id', 'assessable_type_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function assessableType()
    {
        return $this->belongsTo(AssessableType::class);
    }
}
