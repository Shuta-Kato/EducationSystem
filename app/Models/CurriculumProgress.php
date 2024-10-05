<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $fillable = ['curriculums_id','users_id','clear_flg','created_at','updated_at'];

    public function getClearflg($id){
        $user_id = Auth::id();
        $query = DB::table('curriculum_progress')
        -> where('curriculums_id', $id)
        -> where('users_id', $user_id)
        -> value('clear_flg');
        return $query;
    }

    public function updateClearflg($id){
        $user_id = Auth::id();

        CurriculumProgress::updateorCreate(
            [
                'curriculums_id' => $id,
                'users_id'=> $user_id
            ],
            [
                'clear_flg' => 1,   
            ]
            );
    }

}
