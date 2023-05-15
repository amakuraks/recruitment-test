<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BarangRequest extends FormRequest
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
            'nama'      => ['required'],
            'kategori'  => ['required','uppercase'],
            'harga'     => ['required','numeric'],
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'kode'      => ['required','unique:App\Models\Barang,kode','uppercase'],
            ];
        }

        return $rules;
    }
}
