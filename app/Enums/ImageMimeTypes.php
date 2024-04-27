<?php

namespace App\Enums;

use App\Traits\Enumable;

enum ImageMimeTypes: string
{
    use Enumable;

    case WEBP = 'image/webp';
    case JPEG = 'image/jpeg';
    case JPG = 'image/jpg';
    case PNG = 'image/png';
    case SVG = 'image/svg+xml';

}
