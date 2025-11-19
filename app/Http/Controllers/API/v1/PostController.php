<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::with('author')->paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['author_id'] = 1;

        $post = Post::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Post Created Successfully',
            'data' => new PostResource($post)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    // public function show(Post $post) its the same as above so this will not need $post = Post::findOrFail($id);
    {
        $post = Post::findOrFail($id);

        // if (!$post) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Post not found',
        //         'data' => null
        //     ], 404);
        // }

        return response()->json([
            'success' => true,
            'message' => 'Post fetched Successfully',
            'data' => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|min:2',
            'body' => ['required', 'string', 'min:2']
        ]);

        // $post = Post::find($id);
        // $post->title = $data['title'];
        // $post->body = $data['body'];

        // $post->save();

        $post->update($data);

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete($post);

        return response()->noContent();
    }
}
