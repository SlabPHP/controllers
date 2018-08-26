<?php
/**
 * SlabPHP JS Concatenator Controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers\Resources;

class Javascript extends Concatenator
{
    const DEFAULT_DIRECTORY = 'scripts';

    /**
     * @var string
     */
    protected $contentType = 'text/javascript';

    /**
     * Get actual filename
     *
     * @param $filename
     * @return bool|string
     */
    protected function getActualFilename($filename)
    {
        return 'scripts/' . basename($filename);
    }
}