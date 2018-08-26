<?php
/**
 * Tests for the Javascript Concatenator Controller
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Resources;

class JavascriptTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test page controller creation
     */
    public function testController()
    {
        $js = new \Slab\Controllers\Resources\Javascript();

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
            'test.js',
            'test2.js',
        ];
        $route->setParameters($parameters);

        $js->setRouteReference($route);
        $js->setSystemReference($system);

        $response = $js->executeControllerLifecycle();

        $testOutput = '/* scripts/test.js */' . PHP_EOL;
        $testOutput.= "var a = 'Hello';" . PHP_EOL;
        $testOutput.= '/* scripts/test2.js */' . PHP_EOL;
        $testOutput.= 'var b = World();';

        $this->assertEquals(\Slab\Controllers\Resources\CSS::DEFAULT_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>'text/javascript'], $response->getHeaders());
        $this->assertContains($testOutput, $response->getData());
    }
}

