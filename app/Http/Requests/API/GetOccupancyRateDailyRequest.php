<?php

namespace App\Http\Requests\API;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class GetOccupancyRateDailyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $this->sanitize();

        return [
            'rooms_id' => 'sometimes|nullable|exists:rooms,id'
        ];
    }

    /**
     * @throws ValidationException
     */
    private function sanitize()
    {
        $day = $this->route('day');

        if($day == null)
            throw ValidationException::withMessages(['day' => 'Parameter day is required']);

        $input = $this->all();

        $input['starts_at'] = Carbon::parse($day);
        $input['ends_at']   = Carbon::parse($day);

        $this->replace($input);

    }
}
