<?php
/**
 * Slab Controller Response
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers;

class Response implements \Slab\Components\Output\ControllerResponseInterface
{
    /**
     * @var string
     */
    private $resolver;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var integer
     */
    private $statusCode;

    /**
     * Response constructor.
     * @param $resolver
     * @param $data
     * @param $statusCode
     * @param array $headers
     */
    public function __construct($resolver, $data, $statusCode, $headers = [])
    {
        $this->resolver = $resolver;
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}