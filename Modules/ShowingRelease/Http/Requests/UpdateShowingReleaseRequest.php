<?php

namespace Modules\ShowingRelease\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\ShowingRelease\Entities\ShowingRelease;

class UpdateShowingReleaseRequest extends FormRequest
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
            'room_id' => 'required|exists:rooms,id',
            'time_release' => 'required|date_format:H:i',
            'date_release' => 'required|date',
        ];
    }
     /**
     * Add additional validation rules after the base rules have been applied.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $roomId = $this->input('room_id');
            $dateRelease = $this->input('date_release');
            $timeRelease = $this->input('time_release');

            $existingRelease = ShowingRelease::where('room_id', $roomId)
                ->whereDate('date_release', Carbon::createFromFormat('Y-m-d', $dateRelease))
                ->whereTime('time_release', Carbon::createFromFormat('H:i', $timeRelease))
                ->first();

            if ($existingRelease) {
                $validator->errors()->add('time_release', 'Buổi chiếu đã tồn tại trong phòng này vào ngày và giờ đã chọn.');
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
