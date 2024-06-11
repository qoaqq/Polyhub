<?php

namespace Modules\ShowingRelease\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Modules\ShowingRelease\Http\Requests\CreateShowingReleaseRequest;
use Modules\ShowingRelease\Http\Requests\UpdateShowingReleaseRequest;
use Modules\Ticket\Entities\Ticket;

class ShowingReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $movies = Movie::all();
        $query = ShowingRelease::with('movie', 'seat', 'room')->search($request->get('search'));
        if ($request->filled('movie_id')) {
            $query->where('movie_id', $request->input('movie_id'));
        }
    
        $list = $query->latest('id')->paginate(8);
        return view('showingrelease::index', compact('list','movies'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $movie = Movie::pluck('name', 'id');
        $seat = Seat::pluck('column', 'id');
        $room = Room::pluck('name', 'id');
        $data = ShowingRelease::all();
        return view('showingrelease::create', compact('data', 'seat', 'room', 'movie'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateShowingReleaseRequest $request)
    {
        $showingRelease = new ShowingRelease();
        $showingRelease->movie_id = $request->movie_id;
        $showingRelease->seat_id = $request->seat_id;
        $showingRelease->room_id = $request->room_id;
        $showingRelease->date_release = Carbon::createFromFormat('Y-m-d', $request->date_release);
        $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
        $showingRelease->save();

        return redirect()->route('showingrelease.index')->with('success', 'Thêm thành công');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $showingRelease = ShowingRelease::with('seat', 'room', 'movie')->find($id);
        return view('showingrelease::show', compact('showingRelease'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $show = ShowingRelease::find($id);
        $movie = Movie::pluck('name', 'id');
        $seat = Seat::pluck('column', 'id');
        $room = Room::pluck('name', 'id');
        return view('showingrelease::edit', compact('show', 'movie', 'seat', 'room'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateShowingReleaseRequest $request, $id)
    {
        $showingRelease = ShowingRelease::find($id);
        $showingRelease->movie_id = $request->movie_id;
        $showingRelease->seat_id = $request->seat_id;
        $showingRelease->room_id = $request->room_id;

        $showingRelease->date_release =  $request->date_release;
        $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
        $showingRelease->save();

        return redirect()->route('showingrelease.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $showingRelease = ShowingRelease::find($id);
        $showingRelease->delete();
        return redirect()->route('showingrelease.index')->with('success', 'Xóa thành công!');
    }
}
