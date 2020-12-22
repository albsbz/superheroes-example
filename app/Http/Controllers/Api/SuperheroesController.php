<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\Superhero;
use App\Models\Superpower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
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

        if (isset($data['images'])) {
            $hero
                ->images()
                ->attach($data['images']);
        }
        if (isset($data['images'])) {
            $hero
                ->superpowers()
                ->attach($data['superpowers']);
        }

        return response()->noContent();
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
            ->with(['images', 'superpowers'])->first();
        $superpowers = [] && $hero->superpowers->toArray();
        $recomended = [] && Superhero::where('id', '!=', $hero->id)
            ->with(['superpowers'])
            ->whereHas('superpowers', function ($q) use ($superpowers) {
                return $q->whereIn('id', $superpowers);
            })
            ->take(3)
            ->select('nickname', 'id')
            ->get();
        $response = collect()->merge($hero)->merge(['recomended' => $recomended]);
        return json_encode($response);
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
        if (isset($data['images'])) {
            $relatedImages->attach($data['images']);
        }

        $relatedSuperpowers = $hero->superpowers();
        $relatedSuperpowers->detach();
        if (isset($data['superpowers'])) {
            $relatedSuperpowers->attach($data['superpowers']);
        }


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

        return response()->noContent();
    }
    public function createData()
    {
        $allImages = ['allImages' => Image::all('id', 'url')];
        $allSuperpowers = ['allSuperpowers' => Superpower::all('id', 'name')];
        return json_encode(collect()->merge($allImages)->merge($allSuperpowers));
    }
    public function getAll()
    {

        return json_encode(Superhero::with(['images', 'superpowers'])->get()->all());
    }
    public function setFavorites(Request $request)
    {

        foreach ($request->favorites as $favorite) {
            $superhero = Superhero::find($favorite);
            $superhero->favorites = 1;
            $superhero->save();
        }


        return response()->noContent();
    }
}
