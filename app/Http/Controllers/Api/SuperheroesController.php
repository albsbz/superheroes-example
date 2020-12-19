<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\Superhero;
use App\Models\Superpower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuperheroResource;


class SuperheroesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $superpowers = $request->superpower;

        $response = Superhero::with(['images', 'superpowers'])
            ->withSuperpowers($superpowers)
            ->paginate(5);
        return SuperheroResource::collection($response);
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
        $data = $request->validate([
            'nickname' => 'required',
            'real_name' => 'required',
            'catch_phrase' => 'required',
            'origin_description' => 'required',
            'images' => 'nullable',
            'superpowers' => 'nullable',
        ]);
        $hero =  Superhero::create($data);

        $hero
            ->images()
            ->attach($data['images']);
        $hero
            ->superpowers()
            ->attach($data['superpowers']);

        return response(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hero =  Superhero::where('id', $id)
            ->select('id', 'nickname', 'real_name', 'catch_phrase', 'origin_description')
            ->with(['images', 'superpowers'])
            ->get()
            ->first();
        return json_encode($hero);
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

        $data = $request->validate([
            'nickname' => 'required',
            'real_name' => 'required',
            'catch_phrase' => 'required',
            'origin_description' => 'required',
            'images' => 'nullable',
            'superpowers' => 'nullable',
        ]);

        $hero = Superhero::find($id);
        $hero->update($data);
        $relatedImages = $hero->images();
        $relatedImages->detach();

        $relatedImages->attach($data['images']);

        $relatedSuperpowers = $hero->superpowers();
        $relatedSuperpowers->detach();
        $relatedSuperpowers->attach($data['superpowers']);


        return json_encode($hero);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Superhero::find($id)->delete();

        return response(null, 204);
    }
    public function createData()
    {
        $allImages = ['allImages' => Image::all('id', 'url')];
        $allSuperpowers = ['allSuperpowers' => Superpower::all('id', 'name')];
        return json_encode(collect()->merge($allImages)->merge($allSuperpowers));
    }
}
