<?php
/**
 * Tests for the CSS Concatenator Controller
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Resources;

class CSSTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test page controller creation
     */
    public function testController()
    {
        $css = new \Slab\Controllers\Resources\CSS();

        $route = new \Slab\Tests\Components\Mocks\Router\Route();
        $system = new \Slab\Tests\Controllers\Mocks\ResourceSystem();

        $bundleStack = $this->getMockBuilder(\Slab\Tests\Components\Mocks\BundleStack::class)
            ->getMock();

        $bundleStack->method('getResourceDirectories')
            ->willReturn([__DIR__ . '/../Mocks/resources']);

        $bundleStack->method('findResource')
            ->willReturn(true);

        $system->setStack($bundleStack);

        $parameters = new \stdClass();
        $parameters->files = [
            'test.css',
            'test2.css',
        ];
        $route->setParameters($parameters);

        $css->setRouteReference($route);
        $css->setSystemReference($system);

        $response = $css->executeControllerLifecycle();

        $testOutput = '/* styles/test.css */' . PHP_EOL;
        $testOutput.= '#hello {}' . PHP_EOL;
        $testOutput.= '/* styles/test2.css */' . PHP_EOL;
        $testOutput.= '.world {}';

        $this->assertEquals(\Slab\Controllers\Resources\CSS::DEFAULT_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>'text/css'], $response->getHeaders());
        $this->assertContains($testOutput, $response->getData());
    }
}

