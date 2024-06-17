<?php

namespace Modules\Room\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Cinema\Entities\Cinema;
use Modules\Room\Entities\Room;
use Modules\Room\Http\Requests\CreateRoomRequest;
use Modules\Room\Http\Requests\UpdateRoomRequest;

class RoomController extends Controller
{

    protected $model;

    public function __construct(Room $model){
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $rooms = $this->model->with('cinema')->paginate(10);
        return view('room::index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $cinemas = Cinema::all();
        return view('room::create', compact('cinemas'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateRoomRequest $request)
    {
        $data = $request->all();
        $room = $this->model->create($data);
        $rows = [
            'a' => 1, 'b' => 1, 'c' => 1,
            'd' => 2, 'e' => 2, 'f' => 2,
            'g' => 3
        ];
        $seats = [];

        for ($column = 1; $column <= 12; $column++) {
            foreach ($rows as $row => $type) {
                $seats[] = [
                    'row' => $row,
                    'column' => $column,
                    'type' => $type,
                    'status' => 0,
                    'room_id' => $room->id,
                 ];
            }
        }

        DB::table('seats')->insert($seats);
        return redirect()->route('admin.room.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $cinemas = Cinema::all();
        $room = $this->model->with('seats')->find($id);
        $seats = $room->seats->groupBy('row');;
        return view('room::detail', compact('room','cinemas', 'seats'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('room::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateRoomRequest $request, $id)
    {
        $data = $request->all();
        $this->model->findOrFail($id)->update($data);
        return redirect()->route('admin.room.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();
        return redirect()->route('admin.room.index');
    }
}
