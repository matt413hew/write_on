<?php

namespace App\Http\Controllers;

use App\Http\Requests\createArticleRequest;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function createArticle(createArticleRequest $request)
    {
        $article = $request->validated();
        Article::create([
            'title' => $article['title'],
            'company' => $article['company'],
            'link' => $article['link'],
            'date' => new Carbon($article['date']),
            'content' => $article['content'],
            'status' => 1,
            'writer' => auth()->id()
        ]);
        return response(['message' => 'success']);
    }
}
