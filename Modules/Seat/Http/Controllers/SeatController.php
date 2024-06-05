<?php

namespace Modules\Seat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seat\Entities\Seat;

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
    public function store(Request $request)
    {

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
        $seat = $this->model->find($id);
        return view('seat::detail', compact('seat'));
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
    public function update(Request $request, $id)
    {
        $seat = $this->model->find($id);
        $seat->row = $request->row;
        $seat->column = $request->column;
        $seat->save();
        return redirect()->route('admin.seat.index');
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
