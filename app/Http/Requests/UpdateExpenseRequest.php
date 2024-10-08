<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        return $this->user()->can('update', $this->expense)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'date_time' => ['required', 'date'],
            'payment_method' => ['required', 'string', 'max:255'],
        ];
    }
}
