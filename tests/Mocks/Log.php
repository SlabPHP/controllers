<?php
/**
 * input mock
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Mocks;

class Log
{
    /**
     * @param $message
     * @param $context
     */
    public function error($message, $context)
    {
        error_log($message);
    }
}