<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\MOdels\Medicine;

class Request extends Model
{
    protected $fillable = [
        'name',
        'request_number',
        'total_amount',
        'status',
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function updateTotalAmount()
    {
        $total = $this->medicines()->sum(DB::raw('price * quantity'));
        $this->total_amount = $total->save();
    }
}