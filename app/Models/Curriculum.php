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

    public function curriculumProgres(){
        return $this->hasMany(CurriculumProgres::class);
    }

    public function deliveryTimes(){
        return $this->hasMany(DeliveryTime::class);
    }

    public function grade(){
        return $this->belongsTo(Grade::class);
    }

    public function getCurriculums($id){
        $curriculums = DB::table('curriculums')
            ->where('id', $id)
            ->first();
        return $curriculums;
    }

    public function showCurriculums(){
        $curriculums = DB::table('curriculums')->get();
        return $curriculums;
    }
}