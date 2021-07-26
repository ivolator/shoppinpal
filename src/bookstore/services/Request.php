<?php

namespace bookstore\services;

use Exception;

/**
 * Class Request
 * Deal with request parsing
 * Code from my previous project
 * @see Github ivolatr/restlt
 *
 * @package bookstore\services
 */
class Request
{

    const POST = 'POST';
    const GET = 'GET';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const PATCH = 'PATCH';
    const HEAD = 'HEAD';

    protected $supportedMethods = ['POST', 'GET', 'PUT', 'DELETE', 'PATCH', 'HEAD'];
    /**
     *
     * @var array
     */
    protected $queryParams = [];

    /**
     *
     * @var array
     */
    protected $postParams = [];

    /**
     *
     * @var string
     */
    protected string $rawPost;

    /**
     *
     * @var string
     */
    protected string $uri;

    /**
     *
     * @var string
     */
    protected string $method = '';

    /**
     *
     * @var array
     */
    protected array $headers = [];

    /**
     *
     * @var string XML | JSON | TEXT
     */
    protected string $contentType;

    /**
     */
    public function __construct()
    {
        $this->rawPost = file_get_contents("php://input");
        $this->postParams = $_POST;
        $this->queryParams = $_GET;
        $_POST = null;
        $_GET = null;
        $this->headers = $this->buildHeadersList(!empty ($_SERVER) ? $_SERVER : []);
    }

    /**
     *
     * @param array $SERVER
     * @return array
     */
    protected function buildHeadersList(array $SERVER = [])
    {
        $ret = [];

        if ($SERVER) {
            foreach ($SERVER as $k => $v) {
                if (stristr($k, 'http_')) {
                    $res = str_ireplace('http_', '', $k);
                    $ret [$res] = $v;
                }
            }
        }
        return $ret;
    }

    /**
     *
     * @param string $paramName
     * - the POST or GET parameter name
     * @param string|null $returnDefault
     * - return this if there is nothing in $paramName
     * @return
     */
    public function get(string $paramName, string $returnDefault = null)
    {
        $params = array_merge($this->postParams, $this->queryParams);
        if (isset ($params [$paramName]))
            return $params [$paramName];
        return $returnDefault;
    }

    /**
     *
     * @return the $queryStringParams
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     *
     * @return the $postParams
     */
    public function getPostParams()
    {
        return $this->postParams;
    }

    /**
     *
     * @return the $rawPost
     */
    public function getRawPost()
    {
        return $this->rawPost;
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
     * @return the $url
     */
    public function getUri()
    {
        if (!isset($this->uri)) {
            $res = parse_url('/' . trim($_SERVER ['REQUEST_URI'], '/'));
            $this->uri = $res ['path'] ? $res ['path'] : '/';
            $this->uri = str_replace('//', '/', $this->uri);
        }
        return $this->uri;
    }

    /**
     *
     * @return the $method
     */
    public function getMethod(): string
    {

        if (!$this->method) {
            $this->method = !empty ($_SERVER ['HTTP_X_HTTP_METHOD_OVERRIDE']) ? $_SERVER ['HTTP_X_HTTP_METHOD_OVERRIDE'] : $_SERVER ['REQUEST_METHOD'];
        }

        if (!in_array($this->method, [Request::POST, Request::GET, Request::PUT, Request::DELETE, Request::PATCH, Request::HEAD])) {
            throw new Exception('Invalid Method', Response::METHODNOTALLOWED);
        }
        return strtoupper($this->method);
    }

    /**
     *
     * @return  $contentType
     */
    public function getContentType(): string
    {
        $this->contentType = Response::TEXT_PLAIN;
        if (stripos($this->headers ['ACCEPT'], 'json')) {
            $this->contentType = Response::APPLICATION_JSON;
        } elseif (stripos($this->headers ['ACCEPT'], 'xml') || stripos($this->headers ['ACCEPT'], 'html')) {
            $this->contentType = Response::APPLICATION_XML;
        }
        return $this->contentType;
    }

}
