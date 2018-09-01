<?php
/**
 * POSTBackTest Controller Test
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers;

class POSTBackTest extends \PHPUnit\Framework\TestCase
{
    /**
     * The default postback doesn't do much
     */
    public function testPostBack()
    {
        $_POST['submit'] = 'submit';

        $page = new \Slab\Controllers\POSTBack();

        $route = new \Slab\Tests\Components\Mocks\Router\Route();
        $system = new \Slab\Tests\Components\Mocks\System();

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->url = null;

        $this->assertEquals(\Slab\Controllers\POSTBack::POSTBACK_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>'text/html'], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }

    /**
     * Test postback fail without post submit value
     */
    public function testPostBackFail()
    {
        $page = new \Slab\Controllers\POSTBack();

        $route = new \Slab\Tests\Components\Mocks\Router\Route();
        $system = new \Slab\Tests\Components\Mocks\System();

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->url = null;

        $this->assertEquals(\Slab\Controllers\POSTBack::ERROR_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }
}