<?php

namespace Modules\ShowingRelease\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShowingReleaseRequest extends FormRequest
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
            'time_release' => 'required|date_format:H:i', 
            'date_release' => 'required|date',
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
