<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Buttons;

/**
 * Button group.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class Group extends ChildAware
{
    /**
     * Construct.
     *
     * @param array $attributes Html attributes.
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->addClass('btn-group');
    }
}
