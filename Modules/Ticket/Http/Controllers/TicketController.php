<?php

namespace Modules\Ticket\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cinema\Entities\Cinema;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\ShowingRelease\Entities\ShowingRelease;
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
        $showingReleases = ShowingRelease::all(); 

        $list = Ticket::with(['movie', 'seat', 'room', 'cinema', 'showingrelease'])
                ->searchByTimeStart($request->get('search'))
                ->filterByShowingRelease($request->showing_release_id)
                ->latest('id')
                ->paginate(8);
        return view('ticket::index', compact('list', 'showingReleases'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $movie = Movie::pluck('name', 'id');
        $seat = Seat::pluck('column', 'id');
        $room = Room::pluck('name', 'id');
        $cinema = Cinema::pluck('name', 'id');
        $showingReleases = ShowingRelease::select('id', 'time_release', 'date_release')->get();

        // Tạo mảng kết hợp với id làm khóa và chuỗi thời gian/ngày làm giá trị
        $show = $showingReleases->mapWithKeys(function ($item) {
            $formattedDate = Carbon::parse($item['date_release'])->format('d/m/Y');
            return [$item['id'] => $item['time_release'] . '--date: ' . $formattedDate];
        });
        $data = Ticket::all();
        return view('ticket::create', compact('data', 'seat', 'room', 'movie', 'cinema', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateTicketRequest $request)
    {
        $ticket = new Ticket();
        $ticket->movie_id = $request->movie_id;
        $ticket->seat_id = $request->seat_id;
        $ticket->room_id = $request->room_id;
        $ticket->cinema_id = $request->cinema_id;
        $ticket->showing_release_id = $request->showing_release_id;
        $ticket->time_start = Carbon::createFromFormat('H:i', $request->time_start);
        $ticket->save();

        return redirect()->route('ticket.index')->with('success', 'Thêm thành công');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $ticket = Ticket::with('seat', 'room', 'movie', 'cinema', 'showingrelease')->find($id);
        return view('ticket::show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        $movie = Movie::pluck('name', 'id');
        $seat = Seat::pluck('column', 'id');
        $room = Room::pluck('name', 'id');
        $cinema = Cinema::pluck('name', 'id');
        $showingReleases = ShowingRelease::select('id', 'time_release', 'date_release')->get();

        // Tạo mảng kết hợp với id làm khóa và chuỗi thời gian/ngày làm giá trị
        $show = $showingReleases->mapWithKeys(function ($item) {
            $formattedDate = Carbon::parse($item['date_release'])->format('d/m/Y');
            return [$item['id'] => $item['time_release'] . '--date: ' . $formattedDate];
        });

        return view('ticket::edit', compact('movie', 'seat', 'room', 'cinema', 'show', 'ticket'));
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
        $ticket->movie_id = $request->movie_id;
        $ticket->seat_id = $request->seat_id;
        $ticket->room_id = $request->room_id;
        $ticket->cinema_id = $request->cinema_id;
        $ticket->showing_release_id = $request->showing_release_id;
        $ticket->time_start = Carbon::createFromFormat('H:i', $request->time_start);
        $ticket->save();

        return redirect()->route('ticket.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect()->route('ticket.index')->with('success', 'Xóa thành công!');
    }
}
