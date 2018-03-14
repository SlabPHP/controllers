<?php
/**
 * Response Test Controller
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers;

class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test response object
     */
    public function testResponseObject()
    {
        $object = new \Slab\Controllers\Response('test', ['one'=>true,'two'=>'three'], 400, ['Header'=>'Value']);

        $this->assertEquals('test', $object->getResolver());
        $this->assertEquals(['one'=>true,'two'=>'three'], $object->getData());
        $this->assertEquals(400, $object->getStatusCode());
        $this->assertEquals(['Header'=>'Value'], $object->getHeaders());
    }
}