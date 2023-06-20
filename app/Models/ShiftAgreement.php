<?php

namespace App\Models;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShiftAgreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'shift_id',
        'agreement_id',
        'status'
    ];

    /**
     * ความสัมพันธ์กับโมเดล Shift (กะงาน)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

}
