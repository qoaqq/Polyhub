<?php

namespace Modules\Seat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seat\Entities\Seat;
use Modules\Seat\Entities\SeatType;
use Modules\Seat\Http\Requests\CreateSeatRequest;
use Modules\Seat\Http\Requests\UpdateSeatRequest;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;

class SeatController extends Controller
{
    protected $model;
    public function __construct(Seat $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $seats = $this->model->all()->groupBy('row');
        return view('seat::index', compact('seats'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('seat::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateSeatRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['status'] = 1;
        if($data['row'] == 'a' || $data['row'] == 'b'|| $data['row'] == 'c') {
            $data['type'] = 1;
        }else if($data['row'] == 'd' || $data['row'] == 'e'|| $data['row'] == 'f'){
            $data['type'] = 2;
        }else if($data['row'] == 'g'){
            $data['type'] = 2;
        }
        $this->model->create($data);
        return redirect()->route('admin.seat.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $seat = $this->model->with('room')->find($id);
        $seat_types = SeatType::all();
        return view('seat::detail', compact('seat','seat_types'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
       
        return view('seat::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateSeatRequest $request, $id)
    {
        $seat = $this->model->find($id);
        $seat->seat_type_id = $request->seat_type;
        $seat->status = $request->status;
        $seat->save();
        $seat_showings = SeatShowtimeStatus::where('seat_id',$seat->id)->get();
        foreach($seat_showings as $seat_showing){
            $seat_showing->status = $seat->status ? true : false;
            $seat_showing->save();
        }
        return redirect()->route('admin.room.detail', [$request->room_id]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();
        return redirect()->route('admin.seat.index');   
    }
}
