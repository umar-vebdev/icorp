<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request;

class Medicine extends Model
{
        protected $fillable = [
            'request_id',
            'name',
            'price',
            'quantity',
        ];
    
        public function request()
        {
            return $this->belongsTo(Request::class);
        }

        protected static function booted() {

            static::saved(function ($medicine) {
                if($medicine->request) {
                    $medicine->request->updateTotalAmount();
                }
            });

            static::deleted(function ($medicine){
                if($medicine->request) {
                    $medicine->request->updateTotalAmount();
                }
            });
        }
}

