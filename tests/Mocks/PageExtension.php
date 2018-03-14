<?php
/**
 * Page Extension
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Mocks;

class PageExtension extends \Slab\Controllers\Page
{
    /**
     * @var string
     */
    protected $title = 'extension';

    /**
     * @var string
     */
    protected $description = 'description';

    /**
     * @var string
     */
    protected $testValue = 'default';

    /**
     * Set inputs
     */
    protected function setInputs()
    {
        parent::setInputs();

        $this->inputs
            ->addCall('determineTestValue');
    }

    /**
     * Determine test value
     */
    protected function determineTestValue()
    {
        $this->testValue = $this->getRoutedParameter('testValue', $this->testValue);
    }

    /**
     * Set operations
     */
    protected function setOperations()
    {
        parent::setOperations();

        $this->operations
            ->addCall('adjustValue');
    }

    /**
     * Adjust value
     */
    protected function adjustValue()
    {
        $this->testValue = str_repeat($this->testValue, 2);
    }

    /**
     * Set outputs sequence
     */
    protected function setOutputs()
    {
        parent::setOutputs();

        $this->outputs
            ->addCall('setTestValueInOutput');
    }

    /**
     * Set test value in output
     */
    protected function setTestValueInOutput()
    {
        $this->data->testValue = $this->testValue;
    }
}