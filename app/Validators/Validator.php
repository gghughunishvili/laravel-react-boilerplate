<?php

namespace App\Validators;

use App\Exceptions\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator as IlluminateValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Validator as BaseValidator;

class Validator
{
    use ValidatesWhenResolvedTrait;

    protected $paramsBag;

    protected $request;

    public function __construct(Request $request)
    {
        $this->paramsBag = $request->request;
        $this->request = $request;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function request()
    {
        return $this->request;
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->getParamsBag()->all();
    }

    /**
     * Get the validator instance
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        return BaseValidator::make(
            $this->validationData(),
            $this->rules()
        );
    }

    public function getParamsBag()
    {
        return $this->paramsBag;
    }

    public function validate()
    {
        $this->validateResolved();
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('This action is unauthorized.');
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(IlluminateValidator $validator)
    {
        throw new ValidationException($validator->errors());
    }
}
