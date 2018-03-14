<?php
/**
 * Feed Base Controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers;

class Feed extends Sequenced
{
    const TYPE_JSON = 'json';
    const TYPE_XML = 'xml';

    const RESOLVER_XML = '\Slab\Display\Resolvers\XML';
    const RESOLVER_JSON = '\Slab\Display\Resolvers\JSON';

    const CONTENT_TYPE_JSON = 'application/json;charset=utf-8';
    const CONTENT_TYPE_JSONP = 'application/javascript;charset=utf-8';
    const CONTENT_TYPE_XML = 'application/xml;charset=utf-8';

   /**
     * @var string
     */
    protected $contentType;

    /**
     * @var string
     */
    protected $callback;

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * Set input sequencer
     */
    protected function setInputs()
    {
        $this->inputs
            ->addCall('determineCallback')
            ->addCall('determineFeedType');
    }

    /**
     * Determine callback parameter
     */
    protected function determineCallback()
    {
        $this->callback = $this->system->input()->get('callback');
    }

    /**
     * Determine feed type
     */
    protected function determineFeedType()
    {
        $feedType = strtolower($this->getRoutedParameter('feedType', static::TYPE_JSON));

        if ($feedType == static::TYPE_JSON) {
            $this->displayResolver = static::RESOLVER_JSON;
            if (empty($this->callback))
            {
                $this->contentType = static::CONTENT_TYPE_JSON;
            }
            else
            {
                $this->contentType = static::CONTENT_TYPE_JSONP;
            }
            return;
        }

        if ($feedType == static::TYPE_XML)
        {
            $this->displayResolver = static::RESOLVER_XML;
            $this->contentType = static::CONTENT_TYPE_XML;
            return;
        }

        $this->setNotReady("Please specify a valid feed type in the parameter feedType.");
    }

    /**
     * Set operations
     */
    protected function setOperations()
    {
        $this->operations
            ->addCall('initializeFeedData');
    }

    /**
     * Initialize feed data
     */
    protected function initializeFeedData()
    {
        $this->data = new \stdClass();
    }

    /**
     * Set outputs
     */
    protected function setOutputs()
    {

    }

    /**
     * @return \Slab\Components\Output\ControllerResponseInterface
     */
    protected function buildOutputObject()
    {
        $data = new \stdClass();
        $data->callback = $this->callback;
        $data->feedData = $this->data;

        $output = new \Slab\Controllers\Response(
            $this->displayResolver,
            $data,
            $this->statusCode,
            $this->displayHeaders
        );

        return $output;
    }
}