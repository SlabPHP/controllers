<?php
/**
 * Route Mock
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Mocks;

class Route implements \Slab\Components\Router\RouteInterface
{
    /**
     * @var \stdClass
     */
    private $parameters;

    /**
     * @param $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        if (!empty($this->parameters)) return $this->parameters;

        $object = new \stdClass();
        $object->testValue = 'parameter';
        return $object;
    }

    /**
     * @return mixed
     */
    public function getValidatedData()
    {
        $object = new \stdClass();
        return $object;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Test Route';
    }

    /**
     * @param null|array $parameters
     * @return mixed
     */
    public function getPath($parameters = null)
    {
        return '/';
    }
}