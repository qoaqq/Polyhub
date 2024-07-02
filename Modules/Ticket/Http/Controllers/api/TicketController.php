<?php

namespace Modules\Ticket\Http\Controllers\api;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Http\Requests\CreateTicketRequest;
use Modules\Ticket\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $tickets = Ticket::with(['movie', 'seat', 'room', 'cinema', 'showingrelease'])
        ->searchByTimeStart($request->get('search'))
        ->filterByShowingRelease($request->showing_release_id)
        ->latest('id')
        ->paginate(8);

        return response()->json($tickets);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ticket::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $ticket = new Ticket();
            $ticket->movie_id = $request->movie_id;
            $ticket->seat_id = $request->seat_id;
            $ticket->room_id = $request->room_id;
            $ticket->cinema_id = $request->cinema_id;
            $ticket->showing_release_id = $request->showing_release_id;
            $ticket->time_start = Carbon::createFromFormat('H:i', $request->time_start);
            $ticket->save();

            return response()->json(['message' => 'Thêm thành công', 'ticket' => $ticket], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create ticket', 'message' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $ticket = Ticket::with('seat', 'room', 'movie', 'cinema', 'showingrelease')->find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        return response()->json($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ticket::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateTicketRequest $request, $id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->movie_id = $request->movie_id;
        $ticket->seat_id = $request->seat_id;
        $ticket->room_id = $request->room_id;
        $ticket->cinema_id = $request->cinema_id;
        $ticket->showing_release_id = $request->showing_release_id;
        $ticket->time_start = Carbon::createFromFormat('H:i', $request->time_start);
        $ticket->save();

        return response()->json(['message' => 'Cập nhật thành công', 'ticket' => $ticket]);
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->delete();

        return response()->json(['message' => 'Xóa thành công']);
    }
}
