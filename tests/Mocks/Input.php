<?php
/**
 * input mock
 *
 * @package Slab
 * @subpackage Tests
 * @author Eric
 */
namespace Slab\Tests\Controllers\Mocks;

class Input
{
    /**
     * @param $param
     * @return mixed
     */
    public function get($param)
    {
        return !empty($_GET[$param]) ? $_GET[$param] : null;
    }

    /**
     * @param $param
     * @return null
     */
    public function post($param)
    {
        return !empty($_POST[$param]) ? $_POST[$param] : null;
    }
}