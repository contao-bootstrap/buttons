<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Buttons\Dropdown;

use Netzmacht\Html\Attributes;

/**
 * Dropdown items divider.
 *
 * @package Netzmacht\Bootstrap\Buttons\Helper\Dropdown
 */
class Divider extends Attributes implements ItemInterface
{
    /**
     * Construct.
     *
     * @param array $attributes Html attributes.
     */
    public function __construct(array $attributes = array())
    {
        $attributes = array_merge_recursive(
            array(
                'role'  => 'presentation',
                'class' => array('divider'),
            ),
            $attributes
        );

        parent::__construct($attributes);
    }

    /**
     * Generate the divider.
     *
     * @return string
     */
    public function generate()
    {
        return sprintf('<li %s></li>', parent::generate());
    }
}
