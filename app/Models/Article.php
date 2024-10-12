<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;
    public function getArticles(){
        $articles = Article::orderBy('posted_date','desc') ->take(6) -> get();
        return $articles;
    }

    public function getIdArticle($id){
        $article = DB::table("Articles")
        -> where('id', $id)
        -> first();
        return $article;
    }
}
