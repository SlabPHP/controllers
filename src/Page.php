<?php
/**
 * Web Page Controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers;

class Page extends Sequenced implements \Slab\Components\Router\RoutableControllerInterface
{
    const DEFAULT_DISPLAY_RESOLVER = '\Slab\Display\Resolvers\Template';
    const DEFAULT_CONTENT_TYPE = 'text/html;charset=utf-8';
    const DEFAULT_SHELL_TEMPLATE = 'shell.php';

    /**
     * @var string
     */
    protected $shellTemplate;

    /**
     * @var string
     */
    protected $subTemplate;

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->data = new \stdClass();
    }

    /**
     * Set input sequence
     */
    protected function setInputs()
    {
        $this->inputs
            ->addCall('determineContentType')
            ->addCall('determineDisplayResolver')
            ->addCall('determineShellTemplate');
    }

    /**
     * Determine content type
     */
    protected function determineContentType()
    {
        $this->contentType = $this->getRoutedParameter('contentType', static::DEFAULT_CONTENT_TYPE);
    }

    /**
     * Determine display resolver
     */
    protected function determineDisplayResolver()
    {
        $this->displayResolver = $this->getRoutedParameter('displayResolver', static::DEFAULT_DISPLAY_RESOLVER);
    }

    /**
     * Determine shell template
     */
    protected function determineShellTemplate()
    {
        $this->shellTemplate = $this->getRoutedParameter('template', static::DEFAULT_SHELL_TEMPLATE);
    }

    /**
     * Set operations sequence
     */
    protected function setOperations()
    {
        $this->operations
            ->addCall('fetchSubTemplateName');
    }

    /**
     * Fetch sub template name
     */
    protected function fetchSubTemplateName()
    {
        $className = get_called_class();

        if (mb_strpos($className, 'Controllers') === false)
        {
            $this->system->log()->notice("Fully qualified Controller class name does not contain 'Controllers' so we can't automatically discern the sub template name.");
            return;
        }

        $classSegments = explode('\\', $className);

        $templateName = '';
        while (($segment = array_pop($classSegments)) !== 'Controllers')
        {
            if (empty($templateName))
            {
                $templateName = strtolower($segment) . '.php';
            }
            else
            {
                $templateName = strtolower($segment) . DIRECTORY_SEPARATOR . $templateName;
            }
        }

        $this->subTemplate = 'pages' . DIRECTORY_SEPARATOR . $templateName;
    }

    /**
     * Set outputs sequence
     */
    protected function setOutputs()
    {
        $this->outputs
            ->addCall('setShellTemplateInOutput')
            ->addCall('setSubTemplateInOutput');
    }

    /**
     * Set shell template in output
     */
    protected function setShellTemplateInOutput()
    {
        $this->data->template = $this->shellTemplate;
    }

    /**
     * Set sub template in output
     */
    protected function setSubTemplateInOutput()
    {
        $this->data->subTemplate = $this->subTemplate;
    }

    /**
     * @return \Slab\Components\Output\ControllerResponseInterface
     */
    protected function buildOutputObject()
    {
        $output = new \Slab\Controllers\Response(
            $this->displayResolver,
            $this->data,
            $this->statusCode,
            $this->displayHeaders
        );

        return $output;
    }
}