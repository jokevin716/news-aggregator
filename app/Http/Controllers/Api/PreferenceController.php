<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PreferenceController\StoreRequest;
use App\Models\Article;
use App\Models\Preference;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preferences = Preference::all();

        return response()->json($preferences);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function setPreferences(StoreRequest $request)
    {
        $preferences = Preference::updateOrCreate(
            [
                'user_id' => $request->user()->id,
            ],
            [
                'categories' => json_encode($request->categories ?? []),
                'sources' => json_encode($request->sources ?? []),
                'authors' => json_encode($request->authors ?? []),
            ],
        );

        return response()->json($preferences);
    }

    /**
     * Display the specified resource.
     */
    public function getPreferences(Request $request)
    {
        $preferences = $request->user()->preferences;

        if(!$preferences) {
            return response()->json([
                'message' => 'No preferences found',
            ], 404);
        }

        return response()->json($preferences);
    }

    public function fetchPersonalizedFeed(Request $request)
    {
        $preferences = $request->user()->preferences;

        if(!$preferences) {
            return response()->json([
                'message' => 'No preferences set'
            ], 404);
        }

        $query = Article::query();

        // Filter by categories
        if(!empty($preferences->categories)) {
            $query->where(function($q) use ($preferences) {
                foreach(json_decode($preferences->categories) as $category) {
                    $q->orWhere('categories', 'like', '%'.$category.'%');
                }
            });
        }

        // Filter by sources
        if(!empty($preferences->sources)) {
            $query->whereIn('sources', json_decode($preferences->sources));
        }

        // Filter by authors
        if(!empty($preferences->authors)) {
            $query->where(function($q) use ($preferences) {
                foreach (json_decode($preferences->authors) as $author) {
                    $q->orWhere('content', 'like', '%'.$author.'%');
                }
            });
        }

        $articles = $query->orderBy('published_at', 'desc')->paginate($request->input('limit', 10));

        return response()->json($articles);
    }
}
