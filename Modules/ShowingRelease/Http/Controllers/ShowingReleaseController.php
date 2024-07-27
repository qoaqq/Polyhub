<?php

namespace Modules\ShowingRelease\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
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
    $title = "ShowingRelease";
    $movies = Movie::all();
    $sort = $request->get('sort');
    $direction = $request->get('direction', 'desc');
    $query = ShowingRelease::with(['movie' => function($query) {
        // Nếu không cần điều kiện `deleted_at`, loại bỏ chúng
        $query->withoutGlobalScope('notDeleted'); // Nếu có phạm vi toàn cục
    }, 'room'])
    ->search($request->get('search', ''))
    ->sort($sort, $direction);
    
    if ($request->filled('movie_id')) {
        $query->where('movie_id', $request->input('movie_id'));
    }

    $list = $query->latest('id')->paginate(8);
    return view('showingrelease::index', compact('title', 'list', 'movies'));
}


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $movie = Movie::pluck('name', 'id');
        $room = Room::pluck('name', 'id');
        $data = ShowingRelease::all();
        $title = "ShowingRelease create";
        return view('showingrelease::create', compact('data', 'room', 'movie','title'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateShowingReleaseRequest $request)
    {
        // create new release_seats
        DB::beginTransaction();
        try {
            $showingRelease = new ShowingRelease();
            $showingRelease->movie_id = $request->movie_id;
            $showingRelease->room_id = $request->room_id;
            $showingRelease->date_release = Carbon::createFromFormat('Y-m-d', $request->date_release);
            $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
            $showingRelease->save();
            $seats = Seat::where('room_id', $request->room_id)
                        ->get();
            foreach ($seats as $seat) {
                SeatShowtimeStatus::create([
                    'seat_id' => $seat->id,
                    'showtime_id' => $showingRelease->id,
                    'status' => false
                ]);
            }
            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->route('showingrelease.create')->with('error', 'Thêm không thành công');
        }
        return redirect()->route('showingrelease.index')->with('success', 'Thêm thành công');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $showingRelease = ShowingRelease::with('room', 'movie')->find($id);
        $showSeats = SeatShowtimeStatus::with('seat')->where('showtime_id', $id)
        ->get();
        $groupedSeats = $showSeats->groupBy(function ($seatStatus) {
            return $seatStatus->seat->row;
        });
        return view('showingrelease::show', compact('showingRelease', 'groupedSeats'));
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
        $room = Room::pluck('name', 'id');
        $title = "ShowingRelease edit";
        return view('showingrelease::edit', compact('show', 'movie', 'room','title'));
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