<?php

namespace App\Modules\Log\Enums;

enum LogSeverity : string
{
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
    case CRITICAL = 'critical';
    case ALERT = 'alert';
    case EMERGENCY = 'emergency';
    case DEBUG = 'debug';
}
