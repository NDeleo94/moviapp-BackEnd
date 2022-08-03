<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Favorite::join("users", "favorites.id_user", "=", "users.id")
            ->join("movies", "favorites.id_movie", "=", "movies.id")
            ->select(
                "favorites.*",
                "movies.title",
                "users.username"
            )
            ->where('favorites.state', "=", true)
            ->get();
        return $favorites;
    }

    /**
     * Display a listing of the resource by User.
     *
     * @return \Illuminate\Http\Response
     */
    public function byUser($id_user)
    {
        $favorites = Favorite::join("movies", "favorites.id_movie", "=", "movies.id")
            ->join("users", "movies.id_user", "=", "users.id")
            ->select(
                "favorites.id as id_fav",
                "favorites.id_movie as id",
                "movies.title",
                "movies.image",
                "movies.summary",
                "movies.created_at",
                "users.username"
            )
            ->where("favorites.id_user", "=", $id_user)
            ->where("favorites.state", "=", true)
            ->orderBy("id_fav")
            ->get();

        return $favorites;
    }

    /**
     * Display a listing of the resource by Movie.
     *
     * @return \Illuminate\Http\Response
     */
    public function byMovie($id_movie)
    {
        $favorites = Favorite::join("movies", "favorites.id_movie", "=", "movies.id")
            ->select("favorites.*")
            ->where("id_movie", "=", $id_movie)
            ->where("favorites.state", "=", true)
            ->get();

        return $favorites;
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
        $favorite  = new Favorite();
        $favorite->id_user = $request->id_user;
        $favorite->id_movie = $request->id_movie;

        $favorite->save();

        $favorite = Favorite::join("movies", "favorites.id_movie", "=", "movies.id")
            ->join("users", "movies.id_user", "=", "users.id")
            ->select(
                "favorites.id as id_fav",
                "favorites.id_movie as id",
                "movies.title",
                "movies.image",
                "movies.summary",
                "movies.created_at",
                "users.username"
            )
            ->where("favorites.id", "=", $favorite->id)
            ->where("favorites.state", "=", true)
            ->get();

        return $favorite;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $favorite = Favorite::join("movies", "favorites.id_movie", "=", "movies.id")
            ->join("users", "movies.id_user", "=", "users.id")
            ->select(
                "favorites.id as id_fav",
                "favorites.id_movie as id",
                "movies.title",
                "movies.image",
                "movies.summary",
                "movies.created_at",
                "users.username"
            )
            ->where("favorites.id", "=", $id)
            ->where("favorites.state", "=", true)
            ->get();

        return $favorite;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorite = Favorite::findOrFail($id);

        $favorite->state = false;

        $favorite->save();

        return $favorite;
    }
}
