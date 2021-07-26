<?php

namespace bookstore\services;

use bookstore\controllers\Result;
use Exception;

/**
 * @see github ivolator/restlt
 * This file was modified from the original.
 * Some generic methods from restlt
 */
class Response
{

    const OK = 200;

    const CREATED = 201;

    const ACCEPTED = 202;

    const NONAUTHORATIVEINFORMATION = 203;

    const NOCONTENT = 204;

    const RESETCONTENT = 205;

    const PARTIALCONTENT = 206;

    const MULTIPLECHOICES = 300;

    const MOVEDPERMANENTLY = 301;

    const FOUND = 302;

    const SEEOTHER = 303;

    const NOTMODIFIED = 304;

    const USEPROXY = 305;

    const TEMPORARYREDIRECT = 307;

    const BADREQUEST = 400;

    const UNAUTHORIZED = 401;

    const PAYMENTREQUIRED = 402;

    const FORBIDDEN = 403;

    const NOTFOUND = 404;

    const METHODNOTALLOWED = 405;

    const NOTACCEPTABLE = 406;

    const PROXYAUTHENTICATIONREQUIRED = 407;

    const REQUESTTIMEOUT = 408;

    const CONFLICT = 409;

    const GONE = 410;

    const LENGTHREQUIRED = 411;

    const PRECONDITIONFAILED = 412;

    const REQUESTENTITYTOOLARGE = 413;

    const REQUESTURITOOLONG = 414;

    const UNSUPPORTEDMEDIATYPE = 415;

    const REQUESTEDRANGENOTSATISFIABLE = 416;

    const EXPECTATIONFAILED = 417;

    const IMATEAPOT = 418;

    const INTERNALSERVERERROR = 500;

    const NOTIMPLEMENTED = 501;

    const BADGATEWAY = 502;

    const SERVICEUNAVAILABLE = 503;

    const GATEWAYTIMEOUT = 504;

    const HTTPVERSIONNOTSUPPORTED = 505;

    const APPLICATION_JSON = 'application/json';

    const APPLICATION_XML = 'application/xml';

    const TEXT_HTML = 'text/html';

    const TEXT_PLAIN = 'text/plain';

    protected array $headers = [];


    /**
     *
     * @var Exception
     */
    protected Exception $displayError;

    /**
     * HTTP status code
     *
     * @var integer
     */
    protected int $status = 200;

    /**
     *
     * @var
     */
    protected Result $resultObject;

    /**
     *
     * @return Result $reultObject
     */
    public function getResultObject()
    {
        return $this->resultObject;
    }

    /**
     *
     * @param Result $result
     * @return Response
     */
    public function setResultObject(Result $result): Response
    {
        $this->resultObject = $result;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \restlt\ResponseInterface::send()
     */
    public function send($data)
    {
        $contentType = self::APPLICATION_JSON;
        $this->addHeader('Content-Type', $contentType);
        return $this->_send($data);
    }

    /**
     *
     * @param string $name
     * @param string $value
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Send Response
     *
     * @param string $data
     */
    protected function _send($data = null)
    {
        $this->sendHeaders();

        $this->getResultObject()->setHttpStatus($this->status);
        if (isset($this->displayError)) {
            $this->getResultObject()->addError($this->displayError->getMessage(), $this->displayError->getCode());
        }
        if ($data) {
            $this->getResultObject()->setData($data);
            return $this->getResultObject();
        }

        return $this->resultObject;
    }

    protected function sendHeaders(): void
    {
        if (isset($_SERVER['HTTP_CONNECTION'])) {
            header('Allow: POST, GET, PUT, DELETE, PATCH, HEAD');
            header('Connection: close');

            if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
                http_response_code($this->status);
            } else {
                header("HTTP/1.0 " . $this->status);
            }
            foreach ($this->headers as $header => $value) {
                $hStr = $header . ': ' . $value;
                header($hStr, true, $this->status);
            }
        }
    }

    /**
     *
     * @return the $headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *
     * @param field_type $headers
     * @return Response
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     *
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @param int $status
     * @return Response
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Exception
     */
    public function getDisplayError()
    {
        return $this->displayError;
    }

    /**
     * @param Exception $displayError
     */
    public function setDisplayError(Exception $displayError): void
    {
        $this->displayError = $displayError;
    }

    /**
     *
     */
    public function shutdown(Exception $e): Result
    {

        if ($e) {
            $this->displayError = $e;
            $this->setStatus($e->getCode() ?: self::INTERNALSERVERERROR);
        } else {
            $this->setStatus(self::INTERNALSERVERERROR);
            $this->displayError = new Exception('Internal Server Error', Response::INTERNALSERVERERROR);
        }
        $error = error_get_last();
        if (in_array($error['type'], [
            E_ERROR,
            E_USER_ERROR,
            E_CORE_ERROR,
            E_COMPILE_ERROR
        ])) {

            return $this->_send(null);;
        }

        return $this->_send(null);;
    }

}
