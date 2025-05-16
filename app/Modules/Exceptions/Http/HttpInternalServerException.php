<?php

namespace App\Modules\Exceptions\Http;

use App\Modules\Log\Enums\LogSeverity;
use App\Modules\Log\Traits\Loggable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HttpInternalServerException extends \Exception
{
    use Loggable;
    public function __construct(string $message = 'Internal Server Error', int $code = 500)
    {
        parent::__construct($message, $code);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        $this->log($this->message, LogSeverity::ERROR);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => $this->message,
        ], $this->code);
    }
}
