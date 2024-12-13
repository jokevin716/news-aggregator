<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ArticleController\StoreRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pages = 10)
    {
        $articles = Article::query()
            ->orderBy('published_at', 'desc')
            ->paginate($pages);

        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $article = Article::create($request->validated());

        return response()->json([
            'data' => $article,
            'message' => 'Article '.$article->id.' created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        return response()->json($article);
    }

    public function getFilteredArticles(Request $request)
    {
        $query = Article::query();

        // Filter by keyword
        if(!empty($request->input('keyword'))) {
            $query->where('keywords', 'like', '%'.$request->input('keyword').'%');
        }

        // Filter by category
        if(!empty($request->input('category'))) {
            $query->where('categories', 'like', '%'.$request->input('category').'%');
        }

        // Filter by published_at (date only)
        if(!empty($request->input('date'))) {
            $query->whereDate('published_at', $request->input('date'));
        }

        // Filter by source
        if(!empty($request->input('source'))) {
            $query->where('source', $request->input('source'));
        }

        // Paginate the results
        $articles = $query->orderBy('published_at', 'desc')->paginate($request->input('limit', 10));

        return response()->json($articles);
    }
}
