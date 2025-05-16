<?php

namespace App\Modules\Log\Traits;

use App\Modules\Log\Enums\LogSeverity;
use Illuminate\Support\Facades\Log;

trait Loggable
{
    protected function log(string $message, LogSeverity $severity = LogSeverity::DEBUG): void
    {
        $logMessage = sprintf(
            "[%s] %s: %s",
            now()->toDateTimeString(),
            static::class,
            $message
        );
        switch ($severity) {
            case LogSeverity::INFO:
                Log::info($logMessage);
                break;
            case LogSeverity::WARNING:
                Log::warning($logMessage);
                break;
            case LogSeverity::ERROR:
                Log::error($logMessage);
                break;
            case LogSeverity::CRITICAL:
                Log::critical($logMessage);
                break;
            case LogSeverity::ALERT:
                Log::alert($logMessage);
                break;
            case LogSeverity::EMERGENCY:
                Log::emergency($logMessage);
                break;
            case LogSeverity::DEBUG:
                Log::debug($logMessage);
                break;
        }
    }
}
