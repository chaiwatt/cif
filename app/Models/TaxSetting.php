<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'social_contribution_salary',
        'social_contribution_percent',
        'bonus_tax_percent',
    ];
}
 