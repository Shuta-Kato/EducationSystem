<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;

class CurriculumController extends Controller
{
    public function showCurriculumList(){
        $model = new Curriculum();
        $curriculums = $model -> showCurriculums();
        return view('user.curriculum_list');
    }
}
