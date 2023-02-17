<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function all(User $user)
    {
        return $user->posts()
            ->with('user:id,name,usertag,avatar')
            ->with('images')
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate(10);
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $attributes = $request->validate([
            "name" => 'required',
            "caption" => 'required'
        ]);

        $user["name"] = $attributes["name"];
        $user["caption"] = $attributes["caption"];

        $user->save();

        return ($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function updateImage(Request $request)
    {
        $user = auth()->user();

        $user["avatar"] = $request->file('image')->store('profile_images');
        $user->save();

        return $user;
    }

    public function updateBackgroundImage(Request $request)
    {
        $user = auth()->user();

        $user["background_image"] = $request->file('image')->store('background_images');
        $user->save();

        return $user;
    }
}