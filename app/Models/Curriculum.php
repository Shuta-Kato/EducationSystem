<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Curriculum extends Model
{
    use HasFactory;

    public function getCurriculums($id){
        $curriculums = DB::table('curriculums')
        -> where('id', $id)
        -> first();
        return $curriculums;
    }

    public function showCurriculums(){
        $curriculums = DB::table('curriculums')->get();
        return $curriculums;
    }
}
