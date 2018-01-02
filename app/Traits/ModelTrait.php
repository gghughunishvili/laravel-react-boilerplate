<?php

namespace App\Traits;

use App\Exceptions\ResourceNotFoundException;

trait ModelTrait
{
    public static function getExistingModel($id)
    {
        $model = self::find($id);

        if (!$model) {
            $className = strtolower(last(explode("\\", get_called_class())));
            throw new ResourceNotFoundException($className . " not found with id: " . $id);
        }

        return $model;
    }
}
