<?php

namespace App\Http\Requests\Product;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:50'],
            'price'             => ['required', 'numeric'],
            'description'       => ['required', 'string', 'max:200'],
            'image'             => ['nullable', 'string'],
            'expiration_date'   => ['required', 'date', 'after:now()'],
            'category_id'       => ['required', 'numeric'],
        ];
    }
}