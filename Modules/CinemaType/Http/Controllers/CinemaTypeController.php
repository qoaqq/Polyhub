<?php

namespace Modules\CinemaType\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cinema\Entities\Cinema;
use Modules\CinemaType\Entities\CinemaType;
use Modules\CinemaType\Http\Requests\CreateCinemaTypeRequest;
use Modules\CinemaType\Http\Requests\UpdateCinemaTypeRequest;

class CinemaTypeController extends Controller
{

    protected $model;

    public function __construct(CinemaType $model){
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cinemaTypes = $this->model->with('cinema')->paginate(10);
        return view('cinematype::index', compact('cinemaTypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $cinemas = Cinema::all();
        return view('cinematype::create', compact('cinemas'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCinemaTypeRequest $request)
    {
        $data = $request->all();
        $this->model->create($data);
        return redirect()->route('admin.cinematype.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $cinemaType = $this->model->find($id);
        $cinemas = Cinema::all();
        return view('cinematype::detail', compact('cinemaType', 'cinemas'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('cinematype::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCinemaTypeRequest $request, $id)
    {
        $data = $request->all();
        $this->model->find($id)->update($data);
        return redirect()->route('admin.cinematype.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return redirect()->back(); 
    }
}
