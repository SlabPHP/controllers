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
     * @return array
     */
    public function providerController()
    {
        return [
            [
                [
                    'test.css',
                    'test2.css',
                ],
                '/* styles/test.css */' . PHP_EOL . '#hello {}' . PHP_EOL . '/* styles/test2.css */' . PHP_EOL . '.world {}',
            ],
            [
                'test.css',
                '/* styles/test.css */' . PHP_EOL . '#hello {}',
            ]
        ];
    }

    /**
     * Test page controller creation
     * @param array $files
     * @param string $expected
     * @dataProvider providerController
     */
    public function testController($files, $expected)
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
        $parameters->files = $files;
        $route->setParameters($parameters);

        $css->setRouteReference($route);
        $css->setSystemReference($system);

        $response = $css->executeControllerLifecycle();

        $this->assertEquals(\Slab\Controllers\Resources\CSS::DEFAULT_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>'text/css'], $response->getHeaders());
        $this->assertContains($expected, $response->getData());
    }
}

