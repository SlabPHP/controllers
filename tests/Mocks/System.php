<?php
/**
 * Route Mock
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Mocks;

class System implements \Slab\Components\SystemInterface
{
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
        $log = new Log();
        return $log;
    }

    /**
     * @return null
     */
    public function input()
    {
        $input = new Input();

        return $input;
    }

    /**
     * @return null
     */
    public function router()
    {
        $router = new Router();
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
     * @return bool
     */
    public function routeRequest()
    {
        return true;
    }
}