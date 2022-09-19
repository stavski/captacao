<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsoRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Verifica se é código ou número
        if (is_numeric($value) || ctype_alpha($value) && (3 == strlen($value))) {
            return true;
        }

        // Verifica se é lista
        $codigos = json_decode($value);

        if ($codigos) {
            foreach ($codigos as $codigo) {
                if (!is_numeric($codigo) && !ctype_alpha($codigo) || (3 != strlen($codigo))) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Código inválido';
    }
}
