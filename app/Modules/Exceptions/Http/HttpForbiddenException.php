<?php

namespace App\Modules\Exceptions\Http;

use App\Modules\Log\Traits\Loggable;
use Illuminate\Http\JsonResponse;

class HttpForbiddenException extends \Exception
{
    use Loggable;
    private array $extraData;

    public function __construct(string $message = 'Forbidden', int $code = 403, array $extraData = [])
    {
        parent::__construct($message, $code);
        $this->extraData = $extraData;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
            ...$this->extraData
        ], $this->getCode());
    }

    public function report(): void {}
}
