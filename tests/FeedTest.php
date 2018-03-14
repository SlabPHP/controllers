<?php
/**
 * Feed Tests
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers;

class FeedTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test JSON Feed
     */
    public function testJSONFeed()
    {
        $page = new \Slab\Controllers\Feed();

        $route = new Mocks\Route();
        $route->setParameters((object)['feedType'=>'json']);

        $system = new Mocks\System();

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->callback = null;
        $testOutput->feedData = new \stdClass();

        $this->assertEquals(\Slab\Controllers\Feed::RESOLVER_JSON, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>\Slab\Controllers\Feed::CONTENT_TYPE_JSON], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }

    /**
     * Test JSONP feed, JSON with a callback
     */
    public function testJSONPFeed()
    {
        $page = new \Slab\Controllers\Feed();

        $_GET['callback'] = 'something';

        $mocks = new Mocks\Route();
        $mocks->setParameters((object)['feedType'=>'json']);

        $page->setRouteReference($mocks);
        $page->setSystemReference(new Mocks\System());

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->callback = 'something';
        $testOutput->feedData = new \stdClass();

        $this->assertEquals(\Slab\Controllers\Feed::RESOLVER_JSON, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>\Slab\Controllers\Feed::CONTENT_TYPE_JSONP], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }

    /**
     * Test xml feed
     */
    public function testXMLFeed()
    {
        $page = new \Slab\Controllers\Feed();

        $route = new Mocks\Route();
        $route->setParameters((object)['feedType'=>'xml']);

        $system = new Mocks\System();

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->callback = null;
        $testOutput->feedData = new \stdClass();

        $this->assertEquals(\Slab\Controllers\Feed::RESOLVER_XML, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>\Slab\Controllers\Feed::CONTENT_TYPE_XML], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }

    /**
     * Test fail feed response
     */
    public function testFailFeed()
    {
        $page = new \Slab\Controllers\Feed();

        $mocks = new Mocks\Route();
        $mocks->setParameters((object)['feedType'=>'blargh']);

        $page->setRouteReference($mocks);
        $page->setSystemReference(new Mocks\System());

        $response = $page->executeControllerLifecycle();
        $this->assertEquals(500, $response->getStatusCode());
    }
}