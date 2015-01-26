<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Buttons;

use Netzmacht\Bootstrap\Buttons\Dropdown\ItemInterface;
use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * Dropdown button.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class Dropdown extends ChildAware
{
    /**
     * Toggle button.
     *
     * @var Button
     */
    protected $toggle;

    /**
     * Construct.
     *
     * @param array $attributes Html attributes.
     */
    public function __construct(array $attributes = array())
    {
        $attributes = array_merge_recursive(
            array(
                'class'       => array('btn', 'dropdown-toggle'),
                'data-toggle' => 'dropdown'
            ),
            $attributes
        );

        $this->toggle = new Button();

        parent::__construct($attributes);
    }

    /**
     * Set the label.
     *
     * @param string $label The label.
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->toggle->setLabel($label);

        return $this;
    }

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->toggle->getLabel();
    }

    /**
     * Generate the dropdown.
     *
     * @return string
     */
    public function generate()
    {
        $toggle = clone $this->toggle;
        $toggle->addAttributes($this->attributes);
        $toggle->setLabel($toggle->getLabel() . ' ' . Bootstrap::getConfigVar('dropdown.toggle'));

        return sprintf(
            '%s<ul class="dropdown-menu">%s%s</ul>',
            $toggle,
            PHP_EOL,
            $this->generateChildren()
        );
    }

    /**
     * Generate the children.
     *
     * @return string
     */
    protected function generateChildren()
    {
        $buffer = '';

        foreach ($this->children as $child) {
            $buffer .= $child->generate();
            $buffer .= PHP_EOL;
        }

        return $buffer;
    }
}
