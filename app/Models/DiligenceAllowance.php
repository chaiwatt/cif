<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\DiligenceAllowanceClassify;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiligenceAllowance extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function diligenceClassifies()
    {
        return $this->hasMany(DiligenceAllowanceClassify::class, 'diligence_allowance_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
  
}
