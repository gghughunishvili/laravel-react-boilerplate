<?php

namespace App\Traits;

use App\Helpers\Uuid;

trait UuidTrait
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->{$model->getKeyName()}) {
                $model->{$model->getKeyName()} = Uuid::generate();
            }
        });
    }
}
