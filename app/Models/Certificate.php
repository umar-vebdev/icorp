<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{

    use HasFactory;

    protected $fillable = [
    'name',
    'date_of_issue', 
    'validity_period',
    'INN',
    'series',
    'best_before_date',
    'manufacturer',
];
}
