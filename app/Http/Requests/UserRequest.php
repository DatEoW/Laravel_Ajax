<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function isUpdateRequest(): bool
    {
        return $this->route()->getActionMethod() === 'update';
    }
    public function rules(): array
    {
        $rules= [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:mst_users|email',
            'group_role' => 'required',
        ];
        if ($this->isUpdateRequest()) {
            $rules['email'] = 'required|email';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'email.email' => 'Email không đúng định dạng',
            'email.required' => 'Email không được bỏ trống',
            'email.unique'=>'Email không được trùng',
            'name.required'=>'Tên không được bỏ trống',
            'group_role.required'=>'Nhóm user không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống',

        ];
    }
}
