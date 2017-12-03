<?php

namespace Tests\Features\Oauth;

use Tests\TestCase;

class RevokeTokenTest extends TestCase
{

    public function testThatCanLogoutWithAuthorizedUser()
    {
        $response = $this->logoutUser();
        $this->assertEquals(204, $response->getStatusCode(), 'Response HTTP code is 204');
    }
}
