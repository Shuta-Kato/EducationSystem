<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function showArticle($id){
        $model = new Article();
        $article = $model -> getIdArticle($id);
        return view ('user.article',['article'=>$article]);
    }
}
