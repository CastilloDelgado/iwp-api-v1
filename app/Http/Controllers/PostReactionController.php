<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;

class PostReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {
        return PostReaction::create([
            "user_id" => auth()->user()->id,
            "post_id" => $post->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostReaction  $postReaction
     * @return \Illuminate\Http\Response
     */
    public function show(PostReaction $postReaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostReaction  $postReaction
     * @return \Illuminate\Http\Response
     */
    public function edit(PostReaction $postReaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostReaction  $postReaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostReaction $postReaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostReaction  $postReaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $reaction = PostReaction::where([
            ['user_id', "=", auth()->user()->id],
            ['post_id', "=", $post->id]
        ])->first();

        return $reaction->delete();
    }
}