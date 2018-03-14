<?php
/**
 * Trait to add system reference setting in a controller
 *
 * @package Slab
 * @subpackage Controllers
 * @author Eric
 */
namespace Slab\Controllers\Traits;

trait SystemReference
{
    /**
     * @var \Slab\Components\SystemInterface
     */
    protected $system;

    /**
     * @param \Slab\Components\SystemInterface $system
     * @return mixed
     */
    public function setSystemReference(\Slab\Components\SystemInterface $system)
    {
        $this->system = $system;

        return $this;
    }
}