<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title', 
        'thumbnail', 
        'description', 
        'video_url', 
        'alway_delivery_flg', 
        'grade_id',
    ];

    public function curriculumProgres()
    {
        return $this->hasMany(CurriculumProgres::class);
    }

    public function deliveryTimes()
    {
        return $this->hasMany(DeliveryTime::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public static function getCurriculumById($id)
    {
        return self::find($id);
    }

    public static function getAllCurriculums()
    {
        return self::all();
    }

    public static function getCurriculumsSchedule($grade, $startDate, $endDate, $alwaysDeliveryFlag = null)
    {
        $query = self::with(['deliveryTimes' => function ($query) use ($startDate, $endDate) {
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('delivery_from', [$startDate, $endDate])
                    ->orWhereBetween('delivery_to', [$startDate, $endDate]);
            });
        }])
        ->whereHas('grade', function ($query) use ($grade) {
            $query->where('name', $grade);
        });

        if (!is_null($alwaysDeliveryFlag)) {
            $query->whereHas('deliveryTimes', function ($query) use ($alwaysDeliveryFlag) {
                $query->where('alway_delivery_flg', $alwaysDeliveryFlag);
            });
        }

        return $query->get();
    }
}