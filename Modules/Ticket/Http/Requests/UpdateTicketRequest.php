<?php

namespace Modules\Ticket\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Ticket\Entities\Ticket;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'movie_id' => 'required|exists:movies,id',
            'seat_id' => 'required|exists:seats,id',
            'room_id' => 'required|exists:rooms,id',
            'cinema_id' => 'required|exists:cinemas,id',
            'showing_release_id' => 'required|exists:showing_releases,id',
            'time_start' => 'required|date_format:H:i',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $ticketId = $this->route('ticket');
            $movieId = $this->input('movie_id');
            $seatId = $this->input('seat_id');
            $roomId = $this->input('room_id');
            $cinemaId = $this->input('cinema_id');
            $showingReleaseId = $this->input('showing_release_id');
            $timeStart = $this->input('time_start');

            $existingTicket = Ticket::where('movie_id', $movieId)
                ->where('seat_id', $seatId)
                ->where('room_id', $roomId)
                ->where('cinema_id', $cinemaId)
                ->where('showing_release_id', $showingReleaseId)
                ->whereTime('time_start', '=', Carbon::createFromFormat('H:i', $timeStart)->format('H:i:s'))
                ->where('id', '<>', $ticketId)  // Loại trừ vé hiện tại đang được cập nhật
                ->first();

            if ($existingTicket) {
                $validator->errors()->add('showing_release_id', 'Vé đã tồn tại với thông tin đã cung cấp.');
            }
        });
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
