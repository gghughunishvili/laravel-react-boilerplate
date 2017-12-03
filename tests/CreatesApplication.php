<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    protected $baseUrl = 'http://localhost:8000';

    protected $authUrl = 'api/v1/oauth/token';

    protected $clientId;

    protected $clientSecret;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->clientSecret   = env('UNIT_TEST_CLIENT_SECRET', '');
        $this->clientId       = env('UNIT_TEST_CLIENT_ID', '');

        $this->assertNotEmpty($this->clientId, "Client ID not provided. add in env file!");
        $this->assertNotEmpty($this->clientSecret, "Client secret not provided. add in env file!");

        return $app;
    }
}
