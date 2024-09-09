<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'name'              => ['required', 'string', 'max:50', Rule::unique('products')->ignore($this->id)],
            'price'             => ['required', 'numeric', 'min:0'],
            'description'       => ['nullable', 'string', 'max:200'],
            'expiration_date'   => ['required', 'date', 'after:today'],
            'category_id'       => ['required', 'numeric'],
        ];
    }
}
