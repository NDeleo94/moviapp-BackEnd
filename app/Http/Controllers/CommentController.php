<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('state', "=", true)
            ->get();
        return $comments;
    }

    /**
     * Display a listing of the resource by Movie.
     *
     * @return \Illuminate\Http\Response
     */
    public function byMovie($id_movie)
    {
        $comments = Comment::join("users", "comments.id_user", "=", "users.id")
            ->select("comments.*", "users.username")
            ->where('id_movie', '=', $id_movie)
            ->where('comments.state', "=", true)
            ->get();

        return $comments;
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
        $comment = new Comment();

        $comment->comment = $request->comment;

        $comment->id_user = $request->id_user;
        $comment->id_movie = $request->id_movie;

        $comment->save();

        $comment = Comment::join("users", "comments.id_user", "=", "users.id")
            ->select("comments.*", "users.username")
            ->where('comments.id', '=', $comment->id)
            ->where('comments.state', "=", true)
            ->get();

        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $comment = Comment::findOrFail($request->id);

        $comment->comment = $request->comment;

        $comment->save();

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->state = false;

        $comment->save();

        return $comment;
    }
}
