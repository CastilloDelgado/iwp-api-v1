<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $followers = auth()->user()->follows->pluck('id');

        return Post::with('user:id,name,usertag,avatar')
            ->with('images')
            ->whereIn('user_id', $followers)
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate(10);
    }

    public function all()
    {
        return Post::with('user:id,name,usertag,avatar')
            ->with('images')
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required',
        ]);

        $attributes['date'] = Carbon::createFromFormat('d/m/Y', $request->date);
        $attributes['user_id'] = auth()->id();

        $post = Post::create($attributes);

        if ($request['images']) {
            foreach ($request['images'] as $key => $file) {
                $path = $request->file('images')[$key]->store('post_images');
                var_dump($path);
                PostImage::create([
                    'post_id' => $post->id,
                    'url' => $path
                ]);
            }
        }

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post->load('user:id,name,usertag,avatar')->load('images')->load('comments.user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        abort_if($post->user->id !== auth()->id(), 403);
        return response()->json($post->delete(), 200);
    }
}