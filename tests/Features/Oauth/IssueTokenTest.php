<?php

namespace Tests\Features\Oauth;

use Tests\TestCase;

class IssueTokenTest extends TestCase
{

    public function testThatCanAuthWithUserCredentials()
    {
        $response = $this->authAsUser();

        $this->assertEquals(200, $response->getStatusCode(), 'Response HTTP code is 200');

        $this->assertJson($response->getContent(), 'Response is JSON');

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);

        $jsonObject = json_decode($response->getContent());

        $this->assertInternalType("string", $jsonObject->access_token, 'access_token is string');
        $this->assertInternalType("string", $jsonObject->access_token, 'refresh_token is string');
        $this->assertInternalType("string", $jsonObject->token_type, 'token_type is string');
        $this->assertInternalType("int", $jsonObject->expires_in, 'expires_in is int');
    }

    public function testThatCanNotAuthWithBadUserCredentials()
    {
        $response = $this->userCredentialsBadAuth();
        $this->assertEquals(401, $response->getStatusCode(), 'Response HTTP code is 401');
        $this->assertJson($response->getContent(), 'Response is JSON');
        $jsonObject = json_decode($response->getContent());
        $this->assertFalse(property_exists($jsonObject, 'access_token'));
    }

    public function testThatPendingUserCanNotAuth()
    {
        $response = $this->authAsPending();
        $this->assertEquals(401, $response->getStatusCode(), 'Response HTTP code is 401');
        $this->assertJson($response->getContent(), 'Response is JSON');
        $jsonObject = json_decode($response->getContent());
        $this->assertFalse(property_exists($jsonObject, 'access_token'));
    }

    public function testThatPassiveUserCanNotAuth()
    {
        $response = $this->authAsPassive();
        $this->assertEquals(401, $response->getStatusCode(), 'Response HTTP code is 401');
        $this->assertJson($response->getContent(), 'Response is JSON');
        $jsonObject = json_decode($response->getContent());
        $this->assertFalse(property_exists($jsonObject, 'access_token'));
    }
}
