<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::join("users", "movies.id_user", "=", "users.id")
            ->select(
                "movies.id",
                "movies.title",
                "movies.image",
                "movies.summary",
                "movies.created_at",
                "users.username"
            )
            ->where('movies.state', "=", true)
            ->orderBy("movies.id", "asc")
            ->get();

        return $movies;
    }

    /**
     * Display a listing of the resource by User.
     *
     * @return \Illuminate\Http\Response
     */
    public function byUser($id)
    {
        $movies = Movie::where('id_user', "=", $id)
            ->where('state', "=", true)
            ->get();
        return $movies;
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
        $movie = new Movie();

        $movie->title = $request->title;
        $movie->language = $request->language;
        $movie->genre = $request->genre;
        $movie->premiered = $request->premiered;
        $movie->summary = $request->summary;

        $movie->id_user = $request->id_user;

        if ($request->hasFile('image')) {
            $posterMovie = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $posterMovie, 'public');
            $movie["image"] = "$posterMovie";
        }

        $movie->save();

        return $movie;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        return $movie;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function posterMovie(Request $request)
    {
        $posterMovie = storage_path('../public/image/' . $request->filename);
        return response()->download($posterMovie);
        return $posterMovie;
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
        $movie = Movie::findOrFail($request->id);

        $movie->title = $request->title;
        $movie->language = $request->language;
        $movie->genre = $request->genre;
        $movie->premiered = $request->premiered;
        $movie->summary = $request->summary;

        if ($request->hasFile('image')) {
            $posterMovie = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $posterMovie, 'public');
            $movie["image"] = "$posterMovie";
        } else {
            unset($movie["image"]);
        }

        $movie->update();

        return $movie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        $movie->state = false;

        $movie->save();

        return $movie;
    }
}
