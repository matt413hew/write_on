<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth('sanctum')->user();
        if ($user->hasRole('writer') || $user->hasRole('editor')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:articles,id',
            'title' => 'required',
            'company' => 'required|numeric|exists:companies,id',
            'link' => 'required',
            'date' => 'required|date',
            'content' => 'required',
            'image_id' => 'required|exists:images,id',
        ];
    }
}
