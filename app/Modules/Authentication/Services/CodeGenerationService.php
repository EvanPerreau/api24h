<?php

namespace App\Modules\Authentication\Services;

class CodeGenerationService
{
    function generateDigits(int $length): string
    {
        $digits = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $digits[rand(0, 9)];
        }
        return $code;
    }
}
