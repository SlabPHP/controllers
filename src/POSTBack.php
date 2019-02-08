<?php
/**
 * POSTBack Base Controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers;

class POSTBack extends Sequenced
{
    const POSTBACK_DISPLAY_RESOLVER = '\Slab\Display\Resolvers\Redirect';

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * @var string
     */
    protected $redirectURL;

    /**
     * @var string
     */
    protected $redirectRoute;

    /**
     * @var array
     */
    protected $redirectParameters = [];

    /**
     * Set input sequencer
     */
    protected function setInputs()
    {
        $this->inputs
            ->addCall('determineDisplayResolver')
            ->addCall('requireSubmitValue');
    }

    /**
     * Determine display resolver
     */
    protected function determineDisplayResolver()
    {
        $this->displayResolver = $this->getRoutedParameter('displayResolver', static::POSTBACK_DISPLAY_RESOLVER);
    }

    /**
     * Require Submit Value
     */
    protected function requireSubmitValue()
    {
        if ($this->system->input()->post('submit')) {
            echo 'LOOK: ' . $this->system->input()->post('submit') . PHP_EOL;
            return;
        }

        $this->setNotReady("No submit value present.");
    }

    /**
     * Set operations
     */
    protected function setOperations()
    {

    }

    /**
     * Set outputs
     */
    protected function setOutputs()
    {
        $this->outputs
            ->addCall('resolveRedirectRoute');
    }

    /**
     * Resolve redirect route
     */
    protected function resolveRedirectRoute()
    {
        if (empty($this->redirectRoute)) return;

        $route = $this->system->router()->getRouteByName($this->redirectRoute);

        if (empty($route))
        {
            $this->setNotReady("Unable to find route " . $this->redirectRoute);
            return;
        }

        $this->redirectURL = $route->getPath($this->redirectParameters);
    }

    /**
     * @return \Slab\Components\Output\ControllerResponseInterface
     */
    protected function buildOutputObject()
    {
        $data = new \stdClass();
        $data->url = $this->redirectURL;

        $output = new \Slab\Controllers\Response(
            $this->displayResolver,
            $data,
            $this->statusCode,
            $this->displayHeaders
        );

        return $output;
    }
}