<?php

namespace App\Services;

use App\Helpers\Uuid;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;

abstract class AppService
{
    protected $auth;

    protected $database;

    protected $dispatcher;

    public function __construct(
        AuthManager $auth,
        DatabaseManager $database,
        Dispatcher $dispatcher
    ) {
        $this->auth = $auth;
        $this->database = $database;
        $this->dispatcher = $dispatcher;
    }
}
