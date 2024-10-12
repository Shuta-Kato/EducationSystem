<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $table = 'curriculum_progress'; // テーブル名の指定

    protected $fillable = [
        'curriculums_id', 
        'users_id', 
        'clear_flg', 
        'created_at', 
        'updated_at'
    ];

    public function curriculums(){
        return $this->belongsTo(Curriculum::class);
    }

    public function getClearflg($id){
        $user_id = Auth::id();
        return DB::table('curriculum_progress')
            -> where('curriculums_id', $id)
            -> where('users_id', $user_id)
            -> value('clear_flg');
    }

    public function updateClearflg($id){
        $user_id = Auth::id();
        CurriculumProgress::updateOrCreate(
            [
                'curriculums_id' => $id,
                'users_id' => $user_id
            ],
            [
                'clear_flg' => 1,   
            ]
        );
    }
}
