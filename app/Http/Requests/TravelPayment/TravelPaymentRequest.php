<?php

namespace App\Http\Requests\TravelPayment;

use Illuminate\Foundation\Http\FormRequest;

class TravelPaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric|max_digits:6'
        ];
    }
}
