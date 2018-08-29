<?php
/**
 * Web Page Controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers;

class Redirect extends Sequenced implements \Slab\Components\Router\RoutableControllerInterface
{
    const DEFAULT_REDIRECT_RESOLVER = '\Slab\Display\Resolvers\Redirect';

    /**
     * @var string
     */
    protected $redirectURL;

    /**
     * @var int
     */
    protected $cacheLength = 3600;

    /**
     * @var int
     */
    protected $redirectType = 301;

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * Set inputs
     */
    public function setInputs()
    {
        $this->inputs
            ->determineRedirectURL()
            ->determineCacheLength()
            ->determineRedirectType();
    }

    /**
     * Determine redirect url
     */
    protected function determineRedirectURL()
    {
        $this->redirectURL = trim($this->getRoutedParameter('url'));

        if (empty($this->redirectURL))
        {
            $this->setNotReady("Invalid or missing redirect `url` parameter.", null, 404);
        }
    }

    /**
     * Determine cache length
     */
    protected function determineCacheLength()
    {
        $this->cacheLength = intval($this->getRoutedParameter('cacheLength', $this->cacheLength));
    }

    /**
     * Determine redirect type
     */
    protected function determineRedirectType()
    {
        $this->redirectType = intval($this->getRoutedParameter('type', $this->redirectType));

        if (!in_array($this->redirectType, [301, 302]))
        {
            $this->setNotReady("Invalid redirect type specified.", null, 404);
        }
    }

    /**
     * Set operations
     */
    public function setOperations()
    {
        $this->operations
            ->validateRedirectURL();
    }

    /**
     * Validate redirect URL
     */
    protected function validateRedirectURL()
    {
        if (!filter_var($this->redirectURL, FILTER_VALIDATE_URL)) {
            // Not a full URL
            if (!preg_match('#^/[a-zA-Z0-9_/.-]*#', $this->redirectURL)) {
                // Not a valid path either
                $this->setNotReady("Invalid redirect URL entered.", null, 404);
                return;
            }
        }
    }

    /**
     * Set outputs
     */
    public function setOutputs()
    {
        $this->outputs
            ->setUrlInOutput()
            ->setTypeInOutput();
    }

    /**
     * Set url in output
     */
    protected function setUrlInOutput()
    {
        $this->data = new \stdClass();
        $this->data->url = $this->redirectURL;
    }

    /**
     * Set type in output
     */
    protected function setTypeInOutput()
    {
        $this->data->type = $this->redirectType;
    }

    /**
     * Build the output object
     * @return \Slab\Components\Output\ControllerResponseInterface|Response
     */
    protected function buildOutputObject()
    {
        $output = new \Slab\Controllers\Response(
            static::DEFAULT_REDIRECT_RESOLVER,
            $this->data,
            $this->redirectType,
            $this->displayHeaders
        );

        return $output;
    }
}