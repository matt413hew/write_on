<?php

namespace App\Http\Controllers;

use App\Http\Requests\createArticleRequest;
use App\Http\Requests\getArticleRequest;
use App\Http\Requests\publishArticleRequest;
use App\Http\Requests\updateArticleRequest;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function createArticle(createArticleRequest $request)
    {
        $article = $request->validated();
        $saved = Article::create([
            'title' => $article['title'],
            'company' => $article['company'],
            'link' => $article['link'],
            'date' => new Carbon($article['date']),
            'content' => $article['content'],
            'status' => 1,
            'writer' => auth()->id(),
            'slug' => Str::slug($article['title'], "-"),
            'image' => $article['image_id']
        ]);
        return response(['message' => 'success', 'id' => $saved['id']]);
    }

    public function publishArticle(publishArticleRequest $request)
    {
        $data = $request->validated();
        $article = Article::find($data['id']);
        $article->update(['status' => 2, 'editor' => auth('sanctum')->id()]);
        return response(['message' => 'success']);
    }

    public function getForEdit(Request $request)
    {
        $user = auth('sanctum')->user();
        $articles = null;
        if ($user->hasRole('writer')) {
            $articles = $user->writer()->with('img')->with('wrote')->forEdit()->orderBy('id', 'desc')->paginate(5);
        } else {
            $articles = Article::with('img')->with('wrote')->forEdit()->orderBy('id', 'desc')->paginate(5);
        }
        return $articles;
    }

    public function getPublished(Request $request)
    {
        $user = auth('sanctum')->user();
        $articles = null;
        if ($user->hasRole('writer')) {
            $articles = $user->writer()->with('img')->with('wrote')->with('edited')->published()->orderBy('id', 'desc')->paginate(5);
        } else {
            $articles = Article::with('img')->with('wrote')->with('edited')->published()->orderBy('id', 'desc')->paginate(5);
        }
        return $articles;
    }

    public function getAll(Request $request)
    {
        $user = auth('sanctum')->user();
        $articles = null;
        if ($user->hasRole('writer')) {
            $articles = Article::with('img')->with('wrote')->with('edited')->with('statusName')->where('editor', $user['id'])->orWhere('writer', $user['id'])->orderBy('id', 'desc')->paginate(5);
        } else {
            $articles = Article::with('img')->with('wrote')->with('edited')->with('statusName')->orderBy('id', 'desc')->paginate(5);
        }
        return $articles;
    }

    public function getArticle(getArticleRequest $request)
    {
        $data = $request->validated();
        $article = Article::with('img')->find($data['id']);
        return response($article);
    }

    public function updateArticle(updateArticleRequest $request)
    {
        $article = $request->validated();
        $data = Article::find($article['id']);
        $saved = $data->update([
            'title' => $article['title'],
            'company' => $article['company'],
            'link' => $article['link'],
            'date' => new Carbon($article['date']),
            'content' => $article['content'],
            'status' => 1,
            'image' => $article['image_id']
        ]);
        return response(['message' => 'success', 'id' => $data['id']]);
    }
}
