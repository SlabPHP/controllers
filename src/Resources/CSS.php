<?php
/**
 * SlabPHP CSS Concatenator Controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers\Resources;

class CSS extends Concatenator
{
    /**
     * @var string
     */
    protected $contentType = 'text/css';

    /**
     * Get actual filename
     *
     * @param $filename
     * @return bool|string
     */
    protected function getActualFilename($filename)
    {
        return 'styles/' . basename($filename);
    }
}