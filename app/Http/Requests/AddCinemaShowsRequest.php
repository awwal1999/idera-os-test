<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int showId
 * @property string showTime
 */
class AddCinemaShowsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'showId' => 'required|int|exists:shows,id',
            'showTime' =>  'required|date_format: "Y-m-d H:i"'
        ];
    }
}
