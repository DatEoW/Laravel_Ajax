<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules=[
            'name' => 'required|min:5',
                    'price' => 'required|numeric|min:0',
                    'is_sales' => 'required',
                    'img' => 'mimes:png,jpg,jpeg|max:2000',
                    'describe'=>'max:150'

        ];

        return $rules;
    }
    public function messages(){
        return
            [
            'required' => ':attribute không được để trống',
            'name.min' => ':attribute có số ký tự không được bé hơn 5',
            'price.min' => ':attribute không được bé hơn 0',
            'unique' => ':attribute không được trùng',
            'email' => ':attribute phải là định dạng email',
            'numeric' => ':attribute phải là số',
            'mimes' => ':attribute phải là file ảnh đuôi .png,.jpg.jpeg',
            'img.max' => ':attribute không được lớn hơn 2mb',
            'describe.max'=>':attribute không được quá 150 ký tự'

            ];
    }
    public function attributes(){
        return  [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá bán',
            'is_sales' => 'Trạng thái',
            'img' => 'File',
            'describe'=>'Mô tả',
        ];
    }
}