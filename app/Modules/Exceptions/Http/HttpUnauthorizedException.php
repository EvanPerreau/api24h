<?php

namespace App\Modules\Exceptions\Http;

use App\Modules\Log\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class HttpUnauthorizedException extends \Exception
{
    use Loggable;
    public function __construct(string $message = 'Unauthorized', int $code = 401)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->getCode());
    }

    public function report(): void {}
}
