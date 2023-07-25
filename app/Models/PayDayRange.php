<?php

namespace App\Models;

use App\Models\EmployeeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayDayRange extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'employee_type_id',
        'start',
        'end',
        'payday'
    ];

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }
}
