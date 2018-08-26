<?php
/**
 * SlabPHP Resource Concatenator Controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers\Resources;

abstract class Concatenator extends \Slab\Controllers\Sequenced implements \Slab\Components\Router\RoutableControllerInterface
{
    const DEFAULT_DISPLAY_RESOLVER = '\Slab\Display\Resolvers\PlainText';

    /**
     * @var string
     */
    protected $concatenatedData;

    /**
     * @var \Slab\Concatenator\Manager
     */
    protected $concatenator;

    /**
     * Set input call sequence. Overload this function and call the parent in your child class.
     */
    protected function setInputs()
    {
        $this->inputs
            ->createConcatenator()
            ->determineInputFiles();
    }

    /**
     * Create concatenator
     */
    protected function createConcatenator()
    {
        $this->concatenator = new \Slab\Concatenator\Manager();

        $this->concatenator
            ->setFileSearchDirectories($this->system->stack()->getResourceDirectories());
    }

    /**
     * Determine input files from the route parameters
     * @throws \Exception
     */
    protected function determineInputFiles()
    {
        if (empty($this->route->getParameters()->files))
        {
            $this->setNotReady("No input files found.", null, 404);
            return;
        }

        if (is_array($this->route->getParameters()->files))
        {
            foreach ($this->route->getParameters()->files as $file)
            {
                $this->addFileObject((string) $file);
            }
        }
        else
        {
            $this->addFileObject((string) $this->route->getParameters()->files);
        }
    }

    /**
     * Add a file object
     * @param string $file
     */
    private function addFileObject(string $file)
    {
        $file = $this->getActualFilename($file);

        try
        {
            $this->concatenator->addObject($file, []);
        }
        catch (\Exception $e)
        {
            $this->system->log()->error("Failed to add concatenator object: " . $file);
        }
    }

    /**
     * @param $filename
     * @return bool
     */
    abstract protected function getActualFilename($filename);

    /**
     * Set operations call sequence
     */
    protected function setOperations()
    {
        $this->operations
            ->concatenateInputFiles();
    }

    /**
     * Concatenate input files
     */
    protected function concatenateInputFiles()
    {
        $this->concatenator->concatenateObjectList();
    }

    /**
     * Set outputs call sequence
     */
    protected function setOutputs()
    {
        $this->outputs
            ->setConcatenatedDataInTemplate();
    }

    /**
     * Set concatenated data in template
     */
    protected function setConcatenatedDataInTemplate()
    {
        $this->concatenatedData = $this->concatenator->getOutput();
    }

    /**
     * @inheritdoc
     */
    protected function buildOutputObject()
    {
        $output = new \Slab\Controllers\Response(
            \Slab\Controllers\Resources\CSS::DEFAULT_DISPLAY_RESOLVER,
            $this->concatenatedData,
            $this->statusCode,
            $this->displayHeaders
        );

        return $output;
    }
}