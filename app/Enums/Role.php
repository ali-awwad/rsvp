<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel, HasColor, HasIcon
{
    case USER = 'user';
    case VIWER = 'viewer';
    case ADMIN = 'admin';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::VIWER => 'Viewer',
            self::USER => 'User',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ADMIN => 'primary',
            self::VIWER => 'info',
            self::USER => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ADMIN => 'heroicon-o-shield-check',
            self::VIWER => 'heroicon-o-eye',
            self::USER => 'heroicon-o-user',
        };
    }
}
