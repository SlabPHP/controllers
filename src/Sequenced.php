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

    const ERROR_DISPLAY_RESOLVER = '\Slab\Display\Resolvers\PlainText';

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
            $this->executeQueues = false;
            $this->system->log()->error("An error occurred while processing the controller sequence.", $exception);
        }

        if (empty($this->executeQueues)) {
            return $this->buildFailedOutputObject();
        }

        $this->displayHeaders['Content-type'] = $this->contentType;

        return $this->buildOutputObject();
    }

    /**
     * When a call queue fails, this method will be used
     *
     * @return \Slab\Components\Output\ControllerResponseInterface
     */
    protected function buildFailedOutputObject()
    {
        $error = '<!DOCTYPE html><html><head><title>An Error Occurred</title></head><body>';
        $error.= '<h1>Error ' . $this->statusCode . '</h1>';
        $error.= '<p>Sorry about that, please try again later!</p></body></html>';

        $output = new \Slab\Controllers\Response(
            static::ERROR_DISPLAY_RESOLVER,
            $error,
            $this->statusCode,
            ['Content-type' => 'text/html']
        );

        return $output;
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
            $this->system->log()->error($message, [$exception]);
        }
    }
}