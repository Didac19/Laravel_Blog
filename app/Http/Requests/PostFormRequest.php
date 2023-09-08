<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
        $rules = [
            'title' => 'required|max:255|unique:posts,title,'.$this->id,
            'excerpt' => 'required',
            'body' => 'required',
            'image' => ['mimes:jpg,png,jpeg', 'max:5048'],
//            'is_published' => 'required',
            'min_to_read' => 'min:1|max:100'
        ];

        if(in_array($this->method(), ['POST'])){
            $rules['image'] = ['required', 'mimes:jpg,png,jpeg', 'max:5048'];
        }
        return $rules;
    }
}
