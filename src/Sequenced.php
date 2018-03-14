<?php
/**
 * Sequenced Controller Base Class
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers;

abstract class Sequenced
{
    use Traits\SystemReference;
    use Traits\RouteReference;
    use Traits\Sequenced;

    /**
     * @var string
     */
    protected $contentType = 'text/html';

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var string
     */
    protected $displayResolver;

    /**
     * @var array
     */
    protected $displayHeaders = [];

    /**
     * Sequenced constructor.
     */
    public function __construct()
    {
        $this->initializeCallQueues();
    }

    /**
     * Set input call sequence. Overload this function and call the parent in your child class.
     */
    abstract protected function setInputs();

    /**
     * Set operations call sequence
     */
    abstract protected function setOperations();

    /**
     * Set outputs call sequence
     */
    abstract protected function setOutputs();

    /**
     * @return \Slab\Components\Output\ControllerResponseInterface
     */
    public function executeControllerLifecycle()
    {
        try
        {
            $this->setInputs();

            $this->setOperations();

            $this->setOutputs();

            $this->executeCallQueues();
        }
        catch (\Exception $exception)
        {
            $this->system->log()->error("An error occurred while processing the controller sequence.", $exception);
        }

        $this->displayHeaders['Content-type'] = $this->contentType;

        return $this->buildOutputObject();
    }

    /**
     * @return \Slab\Components\Output\ControllerResponseInterface
     */
    abstract protected function buildOutputObject();

    /**
     * @param $message
     * @param null $exception
     * @param int $statusCode
     * @return mixed|void
     */
    protected function setNotReady($message, $exception = null, $statusCode = 500)
    {
        $this->executeQueues = false;
        $this->statusCode = $statusCode;

        if (!empty($message) && $this->system->log())
        {
            $this->system->log()->error($message, $exception);
        }
    }
}