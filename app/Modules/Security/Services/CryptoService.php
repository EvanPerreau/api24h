<?php

namespace App\Modules\Security\Services;

use Illuminate\Support\Facades\Hash;

class CryptoService
{
    function hash(string $data): string
    {
        return Hash::make($data);
    }

    function verify(string $data, string $hash): bool
    {
        return Hash::check($data, $hash);
    }

    function encrypt(string $data): string
    {
        return encrypt($data);
    }

    function decrypt(string $data): string
    {
        return decrypt($data);
    }
}
