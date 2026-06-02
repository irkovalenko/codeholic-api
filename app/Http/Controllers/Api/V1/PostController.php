<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $posts = $user->posts()->latest()->paginate();
        return PostResource::collection($posts);
        //simple ::all() will return post with no user info
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $post = Post::create($data);

        return new PostResource($post);
    }


    public function show(Post $post)
    {

        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }

        //route model binding - laravel get the model by id in url
        // converting to json instead of relying on laravel
        return new PostResource($post);
    }


    public function update(StorePostRequest $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }
        $data = $request->validated();
        $post->update($data);
        return new PostResource($post);
    }


    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }
        $post->delete();
        return new PostResource($post);
    }
}
