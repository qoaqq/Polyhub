<?php

namespace Modules\ShowingRelease\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Modules\ShowingRelease\Http\Requests\UpdateShowingReleaseRequest;

class ShowingReleaseController extends Controller
{
/**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $movies = Movie::all();
        $query = ShowingRelease::with(['movie' => function($query) {
            // Nếu không cần điều kiện `deleted_at`, loại bỏ chúng
            $query->withoutGlobalScope('notDeleted'); // Nếu có phạm vi toàn cục
        }, 'room'])->search($request->get('search'));

        if ($request->filled('movie_id')) {
            $query->where('movie_id', $request->input('movie_id'));
        }

        $list = $query->latest('id')->paginate(8);
        return response()->json([
            'data' => $list,
            'movies' => $movies
        ]);
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
    public function show($id)
    {
        $showingRelease = ShowingRelease::with('room', 'movie')->find($id);
        if ($showingRelease) {
            return response()->json($showingRelease);
        }
        return response()->json(['error' => 'Not Found'], 404);
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
}
