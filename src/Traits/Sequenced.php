<?php
/**
 * Trait to add sequencing to a controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers\Traits;

trait Sequenced
{
    /**
     * @var \Slab\Sequencer\CallQueue
     */
    protected $inputs;

    /**
     * @var \Slab\Sequencer\CallQueue
     */
    protected $operations;

    /**
     * @var \Slab\Sequencer\CallQueue
     */
    protected $outputs;

    /**
     * @var bool
     */
    protected $executeQueues = true;

    /**
     * Sequenced constructor.
     */
    protected function initializeCallQueues()
    {
        $this->inputs = new \Slab\Sequencer\CallQueue();
        $this->operations = new \Slab\Sequencer\CallQueue();
        $this->outputs = new \Slab\Sequencer\CallQueue();
    }

    /**
     * Execute call queues
     * @throws \Exception
     */
    protected function executeCallQueues()
    {
        foreach ($this->inputs->getEntries() as $entry)
        {
            $this->executeCallQueueEntry($entry);
            if (!$this->executeQueues) return;
        }

        foreach ($this->operations->getEntries() as $entry)
        {
            $this->executeCallQueueEntry($entry);
            if (!$this->executeQueues) return;
        }

        foreach ($this->outputs->getEntries() as $entry)
        {
            $this->executeCallQueueEntry($entry);
            if (!$this->executeQueues) return;
        }
    }

    /**
     * @param $entry
     * @throws \Exception
     */
    protected function executeCallQueueEntry(\Slab\Sequencer\Entry $entry)
    {
        if (!method_exists($this, $entry->getMethod()))
        {
            throw new \Exception("The sequence method " . $entry->getMethod() . " does not exist in " . get_called_class());
        }

        call_user_func([$this, $entry->getMethod()], $entry->getParameters());
    }

    /**
     * Stop call queues
     */
    protected function stopCallQueues()
    {
        $this->executeQueues = false;
        $this->inputs->stopExecution();
        $this->operations->stopExecution();
        $this->outputs->stopExecution();
    }

}