<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RestaurantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100|string',
            'name_katakana' => ['required', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
            'comment' => 'required|max:300',
            'review' => ['required', 'regex:/^[1-5]+$/'],
            'tel' => ['regex:/^[0-9-]+$/', 'nullable'],
            'categorieId' => 'required'

        ];
    }
    public function messages()
    {
        return [
            'name.required' => ':attributeは必須項目です。',
            'name.max' => ':attributeは100文字以内です。',
            'name.string' => ':attributeは文字列で入力してください。',
            'name_katakana.required' => ':attributeは必須です。',
            'name_katakana.regex' => ':attributeは全角カタカナで入力してください。',
            'comment.required' => ':attributeは必須です。',
            'comment.max' => ':attributeは300文字以内でです。',
            'tel.regex' => ':attributeを入力してください。',
            'categorieId.required' => ':attributeは必須です。',
            'review.required' => ':attributeは必須です。',
            'review.regex' => ':attributeは1~5の数値で入力ください。'
        ];
    }
    public function attributes()
    {
        return [
            'name' => '店名',
            'name_katakana' => 'フリガナ',
            'comment' => 'コメント',
            'review' => 'レビュー',
            'tel' => '電話番号',
            'categorieId' => 'カテゴリー'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response['status']  = 400;
        $response['statusText'] = 'Failed validation.';
        $response['errors']  = $validator->errors();
        throw new HttpResponseException(
            response()->json($response, 400)
        );
    }
}
