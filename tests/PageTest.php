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

        $page->setRouteReference(new Mocks\Route());
        $page->setSystemReference(new Mocks\System());

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->template = \Slab\Controllers\Page::DEFAULT_SHELL_TEMPLATE;
        $testOutput->subTemplate = 'pages' . DIRECTORY_SEPARATOR . 'page.php';

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

        $route = new Mocks\Route();
        $route->setParameters((object)['testValue'=>'parameter']);

        $page->setRouteReference($route);
        $page->setSystemReference(new Mocks\System());

        $response = $page->executeControllerLifecycle();

        $testOutput = new \stdClass();
        $testOutput->template = \Slab\Controllers\Page::DEFAULT_SHELL_TEMPLATE;
        $testOutput->subTemplate = 'pages' . DIRECTORY_SEPARATOR . 'mocks' . DIRECTORY_SEPARATOR . 'pageextension.php';
        $testOutput->testValue = 'parameterparameter';

        $this->assertEquals(\Slab\Controllers\Page::DEFAULT_DISPLAY_RESOLVER, $response->getResolver());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Content-type'=>'text/html;charset=utf-8'], $response->getHeaders());
        $this->assertEquals($testOutput, $response->getData());
    }
}