<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDraftRequest extends FormRequest
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
        $draftId = $this->route('draft')->id;

        return [
            'title' => 'required|max:255',
            'slug' => 'required|unique:articles,slug,' . $draftId . '|max:255',
            'author_id' => 'required|exists:authors,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ];
    }
}
