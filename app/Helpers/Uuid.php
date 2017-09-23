<?php
namespace App\Helpers;

use Ramsey\Uuid\Uuid as UuidParent;

class Uuid extends UuidParent
{
    public static function generate()
    {
        $uuid = UuidParent::uuid4();
        return $uuid->toString();
    }
}
