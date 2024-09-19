<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurriculumProgress extends Model
{
    use HasFactory;

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

        DB::table('curriculum_progress')
        -> where('curriculums_id', $id)
        -> where('users_id', $user_id)
        -> update([
            'clear_flg' => 1,
        ]);
    }
}
