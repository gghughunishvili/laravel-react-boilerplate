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

        static::creating(function ($model) {
            if (!$model->{$model->getKeyName()}) {
                $model->{$model->getKeyName()} = Uuid::generate();
            }
        });

        static::saving(function ($model) {
            if (!$model->{$model->getKeyName()}) {
                $model->{$model->getKeyName()} = Uuid::generate();
            }
        });
    }
}
