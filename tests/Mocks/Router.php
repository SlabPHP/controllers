<?php
/**
 * router mock
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Mocks;

class Router
{
    /**
     * @param $name
     * @return Route
     */
    public function getRouteByName($name)
    {
        $route = new Route();
        return $route;
    }
}