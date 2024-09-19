<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Banner;

class TopController extends Controller
{
    public function showTop() {
        $model = new Article();
        $articles = $model -> getArticles();

        $model_banner = new Banner();
        $banners = $model_banner ->getBanners();
        return view('user.top',['articles'=>$articles, 'banners'=>$banners]);
    }
}
