<?php

namespace Modules\Bill\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Bill\Entities\Bill;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bills = Bill::with(['ticketSeats', 'user'])->get();

        // dd($bills);
        return view('bill::index',  compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('bill::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $bill = Bill::with([
            'user',
            'checkin',
            'ticketFoodCombo.food_combo',
            'ticketSeats.seat_showTime_status.seat.seatType', 
            'ticketSeats.movie', 
            'ticketSeats.room', 
            'ticketSeats.cinema', 
            'ticketSeats.showingRelease',
        ])->find($id);

        $movie = $bill->ticketSeats->first()->movie;
        $room = $bill->ticketSeats->first()->room;
        $cinema = $bill->ticketSeats->first()->cinema;
        $food_combo = $bill->ticketFoodCombo;
        $checkin = $bill->checkin;

            // dd($checkin->checkin_code);

        return view('bill::show', compact('bill', 'movie', 'room', 'cinema', 'food_combo', 'checkin'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('bill::edit');
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
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
