<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function authAsUser()
    {
        $userIdentifier = env('UNIT_TEST_USER', '');
        $password = env('UNIT_TEST_USER_PASSWORD', '');
        $response = $this->usernamePasswordSuccessfulAuth($userIdentifier, $password);
        return $response;
    }

    protected function authAsPending()
    {
        $userIdentifier = env('UNIT_TEST_PENDING_USER', '');
        $password = env('UNIT_TEST_USER_PENDING_PASSWORD', '');
        $response = $this->usernamePasswordSuccessfulAuth($userIdentifier, $password);
        return $response;
    }

    protected function authAsPassive()
    {
        $userIdentifier = env('UNIT_TEST_PENDING_USER', '');
        $password = env('UNIT_TEST_USER_PENDING_PASSWORD', '');
        $response = $this->usernamePasswordSuccessfulAuth($userIdentifier, $password);
        return $response;
    }

    protected function userCredentialsBadAuth()
    {
        $userIdentifier = env('UNIT_TEST_USER', '');
        $password = env('UNIT_TEST_USER_PASSWORD', '');

        $response = $this->post($this->authUrl, [
            'client_id' => 1,
            'client_secret' => "idontknowmaybesomeinvalidclientsecret",
            'grant_type' => 'password',
            'username' => $userIdentifier,
            'password' => $password,
        ]);

        return $response;
    }

    /**
     * Make valid request for OAuth2 with password grant
     */
    protected function usernamePasswordSuccessfulAuth(string $userIdentifier, string $password)
    {
        $response = $this->post($this->authUrl, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'password',
            'username' => $userIdentifier,
            'password' => $password,
        ]);

        return $response;
    }

    public function callAsUser($method, $url, $data = [], $headers = [])
    {
        $authResponse = $this->authAsUser();
        $accessTokenHeader = $this->parseAccessTokenFromResponseAndTranformToHeader($authResponse);
        $headers = array_merge($headers, $accessTokenHeader);
        $response = $this->json('GET',route('api::auth::user'),[],$headers);
        return $this->json($method, $url, $data, $headers);
    }

    public function logoutUser($headers = [])
    {
        $headers = array_merge($headers, $this->accessTokenHeaderFromLocalVariable());
        $response = $this->json('PATCH', route('api::auth::logout'), [], $headers);
        return $response;
    }

    protected function parseAccessTokenFromResponse(TestResponse $response)
    {
        if (is_null($response)) {
            return null;
        }

        $content = json_decode($response->getContent());

        if (!isset($content->access_token)) {
            return null;
        }

        return $content->access_token;
    }

    public function parseAccessTokenFromResponseAndTranformToHeader(TestResponse $response)
    {
        $this->accessToken = $this->parseAccessTokenFromResponse($response);

        if (is_null($this->accessToken)) {
            return [];
        }

        return [
            'HTTP_Authorization' => 'Bearer ' . $this->accessToken,
        ];
    }
}
