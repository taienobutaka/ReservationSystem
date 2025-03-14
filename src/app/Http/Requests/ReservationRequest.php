<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date|after_or_equal:' . Carbon::tomorrow()->format('Y-m-d'),
            'time' => 'required|date_format:H:i',
            'num_of_users' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください。',
            'date.date' => '有効な日付を入力してください。',
            'date.after_or_equal' => '日付は明日以降の日付でなければなりません。',
            'time.required' => '時間を入力してください。',
            'time.date_format' => '時間はHH:MM形式で入力してください。',
            'num_of_users.required' => '人数を入力してください。',
            'num_of_users.integer' => '人数は整数でなければなりません。',
            'num_of_users.min' => '人数は1人以上でなければなりません。',
        ];
    }
}
