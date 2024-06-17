<?php

namespace Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
