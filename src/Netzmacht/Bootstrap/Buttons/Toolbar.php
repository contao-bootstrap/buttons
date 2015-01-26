<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Buttons;

/**
 * Button Toolbar.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class Toolbar extends ChildAware
{
    /**
     * Construct.
     *
     * @param array $attributes Toolbar attributes.
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->addClass('btn-toolbar');
        $this->setAttribute('role', 'toolbar');
    }
}
