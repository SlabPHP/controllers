<?php
/**
 * Page Controller Test
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers;

class PageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test page controller creation
     */
    public function testPageController()
    {
        $page = new \Slab\Controllers\Page();

        $route = new \Slab\Tests\Components\Mocks\Router\Route();
        $system = new \Slab\Tests\Components\Mocks\System();

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->template = \Slab\Controllers\Page::DEFAULT_SHELL_TEMPLATE;
        $testOutput->subTemplate = 'pages' . DIRECTORY_SEPARATOR . 'page.php';
        $testOutput->title = 'SlabPHP';
        $testOutput->description = 'This is a SlabPHP application.';

        $this->assertEquals(\Slab\Controllers\Page::DEFAULT_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>'text/html;charset=utf-8'], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }

    /**
     * Test page extension
     */
    public function testPageExtension()
    {
        $page = new \Slab\Tests\Controllers\Mocks\PageExtension();

        $route = new \Slab\Tests\Components\Mocks\Router\Route();
        $system = new \Slab\Tests\Components\Mocks\System();

        $route->setParameters((object)['testValue'=>'parameter']);

        $page->setRouteReference($route);
        $page->setSystemReference($system);

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->template = \Slab\Controllers\Page::DEFAULT_SHELL_TEMPLATE;
        $testOutput->subTemplate = 'pages' . DIRECTORY_SEPARATOR . 'mocks' . DIRECTORY_SEPARATOR . 'pageextension.php';
        $testOutput->testValue = 'parameterparameter';
        $testOutput->title = 'extension';
        $testOutput->description = 'description';

        $this->assertEquals(\Slab\Controllers\Page::DEFAULT_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>'text/html;charset=utf-8'], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }
}