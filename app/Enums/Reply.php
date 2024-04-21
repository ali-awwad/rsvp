<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Reply: string implements HasLabel, HasColor, HasIcon
{
    case GOING = 'going';
    case MAYBE = 'maybe';
    case NOT_GOING = 'not_going';

    public function getLabel(): string
    {
        return match ($this) {
            self::GOING => 'Going',
            self::MAYBE => 'Maybe',
            self::NOT_GOING => 'Not Going',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::GOING => 'success',
            self::MAYBE => 'warning',
            self::NOT_GOING => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::GOING => 'heroicon-o-check-circle',
            self::MAYBE => 'heroicon-o-question-mark-circle',
            self::NOT_GOING => 'heroicon-o-x-circle',
        };
    }
}
