<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;

    protected $table = 'delivery_times';

    protected $fillable = [
        'curriculums_id', 
        'delivery_from', 
        'delivery_to',
    ];

    public function curriculums(){
        return $this->belongsTo(Curriculum::class);
    }
}
