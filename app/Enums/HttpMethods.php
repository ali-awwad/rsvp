<?php

namespace App\Enums;

use App\Traits\Enumable;

enum HttpMethods: string
{
    use Enumable;

    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
}
