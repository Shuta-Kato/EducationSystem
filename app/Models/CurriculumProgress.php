<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CurriculumProgres extends Model
{
    use HasFactory;

    protected $table = 'curriculum_progress';

    protected $fillable = [
        'curriculums_id', 
        'users_id', 'clear_flg',
    ];
    
    public function curriculums(){
        return $this->belongsTo(Curriculum::class);
    }
}
