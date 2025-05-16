<?php

namespace App\Modules\Exceptions\Http;

use Illuminate\Http\JsonResponse;

class HttpUnprocessableEntity extends \Exception
{
    public function __construct(string $message = 'Unprocessable Entity', int $code = 422)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }

    public function report(): void{}
}
