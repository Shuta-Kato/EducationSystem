<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{
    use HasFactory;
    public function getBanners(){
       $banners =  Banner::orderBy('id','desc')-> take(4) ->get();
       return $banners;
    }
}
