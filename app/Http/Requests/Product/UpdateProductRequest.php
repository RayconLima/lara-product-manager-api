<?php

namespace App\Http\Requests\Product;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

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
            'description'       => ['nullable', 'string', 'max:200'],
            'expiration_date'   => ['required', 'date', 'after:today'],
            'category_id'       => ['required', 'numeric'],
        ];
    }
}
