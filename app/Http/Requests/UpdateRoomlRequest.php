<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomlRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['sometimes', 'image', 'mimes:png,jpg,jpeg'], //jadi thumbnail tidak diwajibkan untuk diupdate
            'total_people' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            
        ];
    }
}
