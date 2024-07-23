<?php

namespace Modules\ShowingRelease\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Modules\ShowingRelease\Http\Requests\UpdateShowingReleaseRequest;

class ShowingReleaseController extends Controller
{
/**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($movie_id)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $movie = Movie::pluck('name', 'id');
        $room = Room::pluck('name', 'id');
        $data = ShowingRelease::all();
        return response()->json([
            'data' => $data,
            'room' => $room,
            'movie' => $movie
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateShowingReleaseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $showingRelease = new ShowingRelease();
        $showingRelease->movie_id = $request->movie_id;
        $showingRelease->room_id = $request->room_id;
        $showingRelease->date_release = Carbon::createFromFormat('Y-m-d', $request->date_release);
        $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
        $showingRelease->save();
    
        return response()->json(['data' => $showingRelease,'success' => 'Thêm thành công'], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($movie_id)
    {
        $query = ShowingRelease::where('movie_id', $movie_id)->get();
        return response()->json([
            'data' => $query,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $show = ShowingRelease::find($id);
        if ($show) {
            $movie = Movie::pluck('name', 'id');
            $room = Room::pluck('name', 'id');
            return response()->json([
                'show' => $show,
                'movie' => $movie,
                'room' => $room
            ]);
        }
        return response()->json(['error' => 'Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateShowingReleaseRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateShowingReleaseRequest $request, $id)
    {
        $showingRelease = ShowingRelease::find($id);
        if ($showingRelease) {
            $showingRelease->movie_id = $request->movie_id;
            $showingRelease->room_id = $request->room_id;
            $showingRelease->date_release =  $request->date_release;
            $showingRelease->time_release = Carbon::createFromFormat('H:i', $request->time_release);
            $showingRelease->save();
            return response()->json(['data' => $showingRelease,'success' => 'Cập nhật thành công!']);
        }
        return response()->json(['error' => 'Not Found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $showingRelease = ShowingRelease::find($id);
        if ($showingRelease) {
            $showingRelease->delete();
            return response()->json(['success' => 'Xóa thành công!']);
        }
        return response()->json(['error' => 'Not Found'], 404);
    }

    public function getSeatsByShowtime($showtime_id)
    {
        // Lấy toàn bộ ghế theo showtime_id
        $seats = SeatShowtimeStatus::where('showtime_id', $showtime_id)->get();

        return response()->json($seats);
    }

    public function updateSeatStatus(Request $request, $showtime_id, $seat_id)
    {
        // Validate request
        $request->validate([
            'status' => 'required|boolean',
        ]);

        // Tìm ghế theo showtime_id và seat_id
        $seat = SeatShowtimeStatus::where('showtime_id', $showtime_id)
                                    ->where('seat_id', $seat_id)
                                    ->first();

        if (!$seat) {
            return response()->json(['message' => 'Seat not found'], 404);
        }

        // Cập nhật status của ghế
        $seat->status = $request->status;
        $seat->save();

        return response()->json(['message' => 'Seat status updated successfully']);
    }
}

