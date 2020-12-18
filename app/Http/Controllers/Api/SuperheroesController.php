<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\Superhero;
use App\Models\Superpower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuperheroResource;
use phpDocumentor\Reflection\Types\Null_;

class SuperheroesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SuperheroResource::collection(Superhero::with('images')->paginate(5));
        // return Superhero::find(1)->images->pluck('url');
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
    public function show($id)
    {
        $hero =  Superhero::where('id', $id)->select('id', 'nickname', 'real_name', 'catch_phrase')->with(['images', 'superpowers'])->get()->first();
        $allImages = ['allImages' => Image::all('id', 'url', 'superhero_id')];
        $allSuperpowers = ['allSuperpowers' => Superpower::all('id', 'name')];
        return json_encode(collect()->merge($hero)->merge($allImages)->merge($allSuperpowers));
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
            'images' => 'required',
            'superpowers' => 'required',
        ]);



        $hero = Superhero::find($id);

        // dd($hero->images());
        $hero->update($data);
        $relatedImages = $hero->images();
        $relatedImages->delete();
        foreach ($data['images'] as $image) {
            $relatedImages->create([
                'url' => $image['url'],
                'superhero_id' => $id,
            ]);
        }
        // foreach ($hero->images() as $image) {
        //     if (in_array($image, $data['images'])) {
        //         dd($image);
        //     }
        // }
        // dd();

        return $this->show($id);
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
