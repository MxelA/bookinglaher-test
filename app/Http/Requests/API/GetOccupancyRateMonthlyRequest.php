<?php

namespace App\Http\Requests\API;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class GetOccupancyRateMonthlyRequest extends FormRequest
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
        $month = $this->route('monthly');

        if($month == null)
            throw ValidationException::withMessages(['month' => 'Parameter month is required']);


        $input = $this->all();
        $input['starts_at'] = Carbon::parse($month)->startOfMonth();
        $input['ends_at'] = Carbon::parse($month)->endOfMonth();

        $this->replace($input);

    }
}
