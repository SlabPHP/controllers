<?php
/**
 * Route Reference Trait, also provides a vector for reading parameters from the Route
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers\Traits;

trait RouteReference
{
    /**
     * @var \Slab\Components\Router\RouteInterface
     */
    protected $route;

    /**
     * @param \Slab\Components\Router\RouteInterface $route
     * @return $this
     */
    public function setRouteReference(\Slab\Components\Router\RouteInterface $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Function for retrieving routed parameter data from the stored Route reference
     *
     * @param $parameter
     * @param null $default
     * @return null
     */
    protected function getRoutedParameter($parameter, $default = null)
    {
        $output = $default;

        $parameters = $this->route->getParameters();

        if (!empty($parameters->$parameter))
        {
            $output = $parameters->$parameter;
        }

        $validatedData = $this->route->getValidatedData();

        if (!empty($validatedData->$parameter))
        {
            $output = $validatedData->$parameter;
        }

        return $output;
    }
}