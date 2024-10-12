<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryTime extends Model
{
    use HasFactory;

    protected $table = 'delivery_times';

    protected $fillable = [
        'curriculums_id',
        'delivery_from',
        'delivery_to',
    ];

    public function curriculums()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function getDeliveryTime($id)
    {
        $deliveryTime = DB::table('delivery_times')
            ->where('curriculums_id', $id)
            ->first();
        return $deliveryTime;
    }
}