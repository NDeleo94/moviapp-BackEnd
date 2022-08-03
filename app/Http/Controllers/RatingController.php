<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::where("state", "=", true)
            ->get();

        return $ratings;
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
        $rating  = new Rating();
        $rating->id_user = $request->id_user;
        $rating->id_movie = $request->id_movie;
        $rating->rate = $request->rate;

        $rating->save();

        return $rating;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ratingMovie($id_movie)
    {
        $rating = Rating::where("id_movie", "=", $id_movie)
            ->where("state", "=", true)
            ->select(
                Rating::raw('avg(ratings.rate) as rating'),
                Rating::raw('count(ratings.id) as total'),
            )
            ->groupBy("id_movie")
            ->get();

        return $rating;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ratingUserMovie(Request $request)
    {
        $rating = Rating::where("id_user", "=", $request->id_user)
            ->where("id_movie", "=", $request->id_movie)
            ->get();

        return $rating;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function topRating()
    {
        $ratings = Rating::join("movies", "ratings.id_movie", "=", "movies.id")
            ->select(
                "movies.id",
                Rating::raw('count(ratings.id) as total'),
                Rating::raw('avg(ratings.rate) as rating'),
            )
            ->where('ratings.state', "=", true)
            ->where('movies.state', "=", true)
            ->groupBy('movies.id')
            ->orderBy('rating', 'desc')
            ->orderBy('total', 'desc')
            ->limit(1)
            ->get();

        return $ratings;
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
        $rating = Rating::findOrFail($request->id);

        $rating->rate = $request->rate;

        $rating->save();

        return $rating;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
