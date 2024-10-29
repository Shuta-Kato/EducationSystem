<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'banner_images' => 'required|array',
            'banner_images.*' => 'file|image|mimes:jpeg,png,gif', 
        ];
    }

    public function messages()
    {
        return [
            'banner_images.required' => '画像ファイルを選択してください',
            'banner_images.*.image' => '有効な画像ファイルを選択してください',
            'banner_images.*.mimes' => 'jpeg, png, gif形式のみ対応しています',
        ];
    }
}
