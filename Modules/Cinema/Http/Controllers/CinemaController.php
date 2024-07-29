<?php

namespace Modules\Cinema\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cinema\Entities\Cinema;
use Modules\Cinema\Http\Requests\CreateCinemaRequest;
use Modules\Cinema\Http\Requests\UpdateCinemaRequest;
use Modules\City\Entities\City;

class CinemaController extends Controller
{
    protected $model;

    public function __construct(Cinema $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cinemas = $this->model->with('city')->orderBy('id', 'DESC')->paginate(10);
        return view('cinema::index', compact('cinemas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $cities = City::get();
        return view('cinema::create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCinemaRequest $request)
    {
        $data = $request->all();
        $data['rate_point'] = 0;
        $this->model->create($data);
        if(isset($data['city_page'])){
        return redirect()->route('admin.city.show', [$data['city_id']]);
        }
        return redirect()->route('admin.cinema.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $cinema = $this->model->with('city')->find($id);
        return view('cinema::show', compact('cinema'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $cinema = $this->model->find($id);
        $cities = City::get();
        return view('cinema::update', compact('cinema', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCinemaRequest $request, $id)
    {
        $data = $request->all();
        $this->model->find($id)->update($data);
        return redirect()->route('admin.cinema.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();
        return redirect()->back();
    }
}
