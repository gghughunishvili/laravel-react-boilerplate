<?php

namespace App\Traits;

trait MyResponseTrait
{

    protected $statusCode = 200;

    /**
     * Gets the status code.
     * @return     Integer  The status code.
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the status code.
     * @param      Integer $statusCode The status code
     * @return     Integer  ( $this )
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * General response
     * @param      <array>  $data     The data
     * @param      array $headers The headers
     * @return     <json>  (  )
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Returns success status that shoul be used for GET, PUT, PATCH or DELETE
     * and POST that doesn't create object.
     * @param      string $message The message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondSuccess($message = 'Success!')
    {
        return $this->setStatusCode(200)->respond($message);
    }

    /**
     * Returns created status
     * @param      string $message The message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($message = 'Created!')
    {
        return $this->setStatusCode(201)->respond($message);
    }

    /**
     * Returns accepted status
     * @param      string $message The message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondAccepted($message = 'Accepted!')
    {
        return $this->setStatusCode(202)->respond($message);
    }

    /**
     * No content, usually when we delete the object
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNoContent()
    {
        return $this->setStatusCode(204)->respond([]);
    }

    /**
     * Returns bad request exception
     * @param      string $message The message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondErrorBadRequest($message = "Bad Request!")
    {
        return $this->setStatusCode(400)->respond($message);
    }

    /**
     * Returns General Error Exception
     * @param      string $message The message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondError($message = 'General Error!')
    {
        return $this->setStatusCode(400)->respond($message);
    }

    /**
     * Unauthorized response
     * @param      string $message The message
     * @return     json  ( description_of_the_return_value )
     */
    public function respondUnauthorized($message = 'Unauthorized.')
    {
        return $this->setStatusCode(401)->respond($message);
    }

    /**
     * For internal error
     * @param      string $message The message
     * @return     json  ( returns json data)
     */
    public function respondForbidden($message = 'Forbidden!')
    {
        return $this->setStatusCode(403)->respond($message);
    }

    /**
     * Returns not found error exception
     * @param      string $message The message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondErrorNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respond($message);
    }

    /**
     * Unauthorized response
     * @param      string $message The message
     * @return     json  ( description_of_the_return_value )
     */
    public function respondErrorValidation($errors = [])
    {
        return $this->setStatusCode(422)->respond($errors);
    }

    /**
     * Unauthorized response
     * @param      string $message The message
     * @return     json  ( description_of_the_return_value )
     */
    public function respondErrorWithSingleValidationMessage($message = "")
    {
        return $this->setStatusCode(422)->respond($message);
    }

    /**
     * For internal error
     * @param      string $message The message
     * @return     json  ( returns json data)
     */
    public function respondErrorInternal($message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respond($message);
    }
}
