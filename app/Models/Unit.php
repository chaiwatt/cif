<?php

namespace App\Models;

use App\Models\IncomeDeduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    public function incomeDeducts()
    {
        return $this->hasMany(IncomeDeduct::class);
    }
}
