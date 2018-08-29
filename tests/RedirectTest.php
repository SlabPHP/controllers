<?php
/**
 * Redirect Tests
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers;

class RedirectTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return array
     */
    public function providerValidRedirect()
    {
        return [
            [
                '/blargh',
                302,
            ],
            [
                'http://www.blargh.com/',
                301,
            ],
            [
                '/',
                null,
            ]
        ];
    }

    /**
     * Test Valid Redirect Feed
     * @param string $url
     * @param int|null $type
     * @dataProvider providerValidRedirect
     */
    public function testValidRedirect($url, $type)
    {
        $page = new \Slab\Controllers\Redirect();

        $parameters = new \stdClass();
        $parameters->url = $url;
        $expectedType = 301;
        if (!empty($type))
        {
            $expectedType = $type;
            $parameters->type = $type;
        }

        $route = new \Slab\Tests\Components\Mocks\Router\Route();
        $system = new \Slab\Tests\Components\Mocks\System();
        $route->setParameters($parameters);

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->url = $url;
        $testOutput->type = $expectedType;

        $this->assertEquals(\Slab\Controllers\Redirect::DEFAULT_REDIRECT_RESOLVER, $response->getResolver());
        $this->assertEquals($expectedType, $response->getStatusCode());
        $this->assertEquals($testOutput, $response->getData());
    }

    /**
     * @return array
     */
    public function providerInvalidRedirect()
    {
        return [
            // Missing URL
            [
                '',
                301,
            ],
            // null url
            [
                null,
                null,
            ],
            // Invalid url
            [
                'asdfasdf',
                301,
            ],
            // Invalid type
            [
                '/asdf',
                500,
            ]
        ];
    }

    /**
     * Test invalid redirects
     * @param string $url
     * @param int|null $type
     * @dataProvider providerInvalidRedirect
     */
    public function testInvalidRedirect($url, $type)
    {
        $page = new \Slab\Controllers\Redirect();

        $parameters = new \stdClass();
        $parameters->url = $url;
        $expectedType = 404;
        if (!empty($type))
        {
            $parameters->type = $type;
        }

        $route = new \Slab\Tests\Components\Mocks\Router\Route();
        $system = new \Slab\Tests\Components\Mocks\System();
        $route->setParameters($parameters);

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $this->assertEquals(\Slab\Controllers\Sequenced::ERROR_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertContains('Error 404', $response->getData());
    }
}