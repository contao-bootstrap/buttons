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
     * @param bool  $vertical   If true a vertical button group is created.
     */
    public function __construct(array $attributes = array(), $vertical = false)
    {
        parent::__construct($attributes);

        if ($vertical) {
            $this->addClass('btn-group-vertical');
        } else {
            $this->addClass('btn-group');
        }

        $this->setAttribute('role', 'group');
    }
}
