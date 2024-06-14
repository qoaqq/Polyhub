<?php

namespace Modules\ShowingRelease\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\ShowingRelease\Entities\ShowingRelease;

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
            if ($this->hasConflict()) {
                $validator->errors()->add('date_release', 'Ngày này đã có suất chiếu');
                $validator->errors()->add('time_release', 'Giờ này đã có suất chiếu');
                $validator->errors()->add('room_id', 'Phòng này đã có suất chiếu');
            }
        });
    }

    /**
     * Check if there is a conflict with another showing release.
     *
     * @return bool
     */
    protected function hasConflict()
    {
        return ShowingRelease::where('room_id', $this->room_id)
            ->where('date_release', $this->date_release)
            ->where('time_release', $this->time_release)
            ->exists();
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
