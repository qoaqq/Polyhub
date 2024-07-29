<?php
namespace Modules\ShowingRelease\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\ShowingRelease\Entities\ShowingRelease;

class UpdateShowingReleaseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'movie_id' => 'sometimes|nullable|exists:movies,id',
            'room_id' => 'sometimes|nullable|exists:rooms,id',
            'time_release' => 'sometimes|nullable|date_format:H:i',
            'date_release' => 'sometimes|nullable|date_format:Y-m-d|after_or_equal:today',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $showingRelease = ShowingRelease::find($this->route('showingrelease'));
            
            // Kiểm tra xem có thay đổi gì không
            if ($this->input('movie_id') == $showingRelease->movie_id &&
                $this->input('room_id') == $showingRelease->room_id &&
                $this->input('date_release') == $showingRelease->date_release &&
                $this->input('time_release') == $showingRelease->time_release) {
                return; // Không kiểm tra trùng lặp nếu không có thay đổi
            }

            $roomId = $this->input('room_id');
            $dateRelease = $this->input('date_release');
            $timeRelease = $this->input('time_release');

            if ($roomId && $dateRelease && $timeRelease) {
                $existingRelease = ShowingRelease::where('room_id', $roomId)
                    ->whereDate('date_release', Carbon::createFromFormat('Y-m-d', $dateRelease))
                    ->whereTime('time_release', Carbon::createFromFormat('H:i', $timeRelease))
                    ->where('id', '<>', $showingRelease->id) // Exclude the current record
                    ->first();

                if ($existingRelease) {
                    $validator->errors()->add('time_release', 'Buổi chiếu đã tồn tại trong phòng này vào ngày và giờ đã chọn.');
                }
            }
        });
    }

    public function authorize()
    {
        return true;
    }
}
