<?php


namespace bookstore\controllers;

use JsonSerializable;

/**
 * Class Result
 * @package bookstore\controllers
 */
class Result implements JsonSerializable
{

    /**
     *
     * @var integer
     */
    public $httpStatus;

    /**
     *
     * @var mixed
     */
    public $data;

    /**
     *
     * @var array
     */
    public $errors = [];

    /**
     * @return the $errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    public function addError($errorMessage, $errorCode)
    {
        $this->errors/* ['error'] */
        [] = ['message' => $errorMessage, 'code' => $errorCode];
        return $this;
    }

    /**
     * @return the $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
        return $this;
    }

    public function __toString()
    {
        return $this->jsonSerialize();
    }

    /**
     * @return false|mixed|string
     */
    public function jsonSerialize()
    {
        return  get_object_vars($this) ;
    }
}