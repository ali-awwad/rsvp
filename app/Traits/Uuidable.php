<?php

namespace App\Traits;

trait Uuidable
{
    protected static function bootUuidable(): void
    {
        static::creating(function ($model) {
            $model->uuid = \Illuminate\Support\Str::uuid();
        });
    }
}
