<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PelangganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $auth = Auth::check();
        // if(!$auth){
        //     return $auth;
        // }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'nama'          => ['required'],
            'domisili'      => ['required'],
            'jenis_kelamin' => ['required','uppercase','in:PRIA,WANITA'],
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'id_pelanggan'  => ['required','unique:App\Models\Pelanggan,id_pelanggan','uppercase'],
            ];
        }

        return $rules;
    }
}
