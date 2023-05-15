<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PenjualanRequest extends FormRequest
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
            'barang'                => ['required','array'],
            'barang.*.kode_barang'  => ['required','uppercase'],
            'barang.*.quantity'     => ['required','integer','gt:0'],
            'tanggal_transaksi'     => ['required','date'],
            'kode_pelanggan'        => ['required','uppercase'],
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'id_nota'      => ['required','unique:App\Models\Penjualan,id_nota','uppercase'],
            ];
        }
        // $rules=[];
        return $rules;
    }
}
