<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*
        ! Abilitare sempre su true per dare a tutti l'autorizzazione Bearer
        */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        /* Unique:users,email vuol dire unica nella tabella users colonna email */

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password'=>[
                'required',
                'confirmed',
                Password::min(8)->letters()->symbols()
            ]
        ];
    }
}
