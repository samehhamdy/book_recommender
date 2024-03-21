<?php

namespace App\Http\Requests;

use App\Rules\IntervalEndPageRule;
use App\Rules\IntervalStartPageRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IntervalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'start_page' => ['required', 'integer', 'min:1', new IntervalStartPageRule],
            'end_page' => ['required', 'integer', 'min:1', 'gte:start_page', new IntervalEndPageRule]
        ];
    }
}
