<?php
/**
 * System Mock for Resources
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Mocks;

class ResourceSystem implements \Slab\Components\SystemInterface
{
    /**
     * @var \Slab\Tests\Components\Mocks\BundleStack
     */
    private $stack;

    /**
     * @return null
     */
    public function config()
    {
        return null;
    }

    /**
     * @return null
     */
    public function session()
    {
        return null;
    }

    /**
     * @return null
     */
    public function log()
    {
        $log = new \Slab\Tests\Components\Mocks\Log();
        return $log;
    }

    /**
     * @return null
     */
    public function input()
    {
        $input = new \Slab\Tests\Components\Mocks\Input();

        return $input;
    }

    /**
     * @return null
     */
    public function router()
    {
        $router = new \Slab\Tests\Components\Mocks\Router\Router();
        return $router;
    }

    /**
     * @return null
     */
    public function db()
    {
        return null;
    }

    /**
     * @return null
     */
    public function cache()
    {
        return null;
    }

    /**
     * @param mixed $mock
     */
    public function setStack($mock)
    {
        $this->stack = $mock;
    }

    /**
     * @return null|\Slab\Components\BundleStackInterface
     */
    public function stack()
    {
        return $this->stack;
    }

    /**
     * @return bool
     */
    public function routeRequest()
    {
        return true;
    }

    /**
     * @return null|\Slab\Components\Debug\ManagerInterface
     */
    public function debug()
    {
        return null;
    }
}