<?php

namespace App\Http\Requests;

use App\Models\Expense;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Expense::class);
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
        ];
    }
}
