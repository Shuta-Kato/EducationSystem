<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurriculumProgress extends Model
{
    use HasFactory;

<<<<<<< HEAD
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
=======
    protected $fillable = ['curriculums_id','users_id','clear_flg','created_at','updated_at'];

    public function getClearflg($id){
        $user_id = Auth::id();
        $query = DB::table('curriculum_progress')
        -> where('curriculums_id', $id)
        -> where('users_id', $user_id)
        -> value('clear_flg');
        return $query;
>>>>>>> origin/team_develop
    }

    public function updateClearflg($id){
        $user_id = Auth::id();
<<<<<<< HEAD
        CurriculumProgress::updateOrCreate(
            [
                'curriculums_id' => $id,
                'users_id' => $user_id
=======

        CurriculumProgress::updateorCreate(
            [
                'curriculums_id' => $id,
                'users_id'=> $user_id
>>>>>>> origin/team_develop
            ],
            [
                'clear_flg' => 1,   
            ]
<<<<<<< HEAD
        );
    }
=======
            );
    }

>>>>>>> origin/team_develop
}
