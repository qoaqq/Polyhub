<?php

namespace Modules\Actor\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Actor\Entities\Actor;
use Modules\Actor\Entities\Movie;
class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = 'Actor';
        $title2 = 'List Actor';
        $movie = Movie::all();
        $actor = Actor::query()->orderByDesc('created_at');
        $page = $actor->paginate(4);
        return view('actor::index', compact('title','title2','page','actor','movie'));
        //return view('actor::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = ' Actor';
        $title2 = 'Add New Actor';
        $movie = Movie::all();
        return view('actor::create', compact('title','title2','movie'));
        // return view('actor::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'avatar' => 'required',
            'movie_id' => 'required'            
        ]);
        if($request->hasFile('avatar')){
            $request->validate([
                'avatar' => 'mimes:jpg,png,jpeg,gif'
            ]);
            $avatar = $request->file('avatar');
            $fileName = $avatar->getClientOriginalName();
            $path = $avatar->storeAs('public/actors',$fileName); 

            $input = [
                'name' => $request->name,
                'gender' => $request->gender,
                'avatar' => $fileName,
                'movie_id' => $request->movie_id,
                'created_at' => now(),
                'updated_at' => null
            ];

            Actor::create($input);
           
        }
        return redirect(route('actor.list'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $listactor = Actor::find($id);
        $title = ' Actor';
        $title2 = 'Detail Actor';
        $movie = Movie::all();
        return view('actor::show', compact('listactor','title','title2','movie'));
        // return view('actor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // return view('actor::edit');
        $listactor = Actor::find($id);
        $title = ' Actor';
        $title2 = 'Update Actor';
        $movie = Movie::all();
        return view('actor::edit', compact('listactor','title','title2','movie'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
        $actor = Actor::find($id);
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'movie_id' => 'required'            
        ]);
        if($request->hasFile('avatar')){
            $request->validate([
                'avatar' => 'mimes:jpg,png,jpeg,gif'
            ]);
            $avatar = $request->file('avatar');
            $fileName = $avatar->getClientOriginalName();
            $path = $avatar->storeAs('public/actors',$fileName); 

            $input = [
                'name' => $request->name,
                'gender' => $request->gender,
                'avatar' => $fileName,
                'movie_id' => $request->movie_id,
                'updated_at' => now()
            ];

            $actor->update($input);
           
        }
        else{
            $input = [
                'name' => $request->name,
                'gender' => $request->gender,
                'avatar' => $request->avatar,
                'movie_id' => $request->movie_id,
                'updated_at' => now()
            ];
            $actor->update($input);
        }
        return redirect(route('actor.list'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $actor = Actor::find($id);
        $actor->delete();
        return redirect(route('actor.list'));

    }
    public function search(Request $request){
        $text = $request->text;
        $actor = Actor::where('name', 'like','%'.$text.'%');
        $title = 'Actor';
        $title2 = 'List Actor';
        $movie = Movie::all();
        $page = $actor->paginate(4);
        return view('actor::search', compact('title','title2','actor','movie','page'));
    }
    public function bin()
    {
        $listvalue = Actor::onlyTrashed();
        $page = $listvalue->paginate(4);
        $title = ' Actor';
        $title2 = 'List Bin Actor';
        $movie = Movie::all();
        return view('actor::bin', compact('listvalue','title','title2','movie','page'));
    }
    public function restore($id){
        Actor::onlyTrashed()->where('id', '=', $id)->restore();
        return redirect(route('actor.list'));
    }
    public function forceDelete($id){
        Actor::onlyTrashed()->where('id', '=', $id)->forceDelete();
        return redirect(route('actor.list'));
    }

}
