<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Buttons;

use Netzmacht\Html\Attributes;

/**
 * Button factory.
 *
 * @package Netzmacht\Bootstrap\Components\Button
 */
class Factory
{
    /**
     * Create button from fieldset defintiion.
     *
     * @param string|array $definition Button definition.
     *
     * @return Group|Toolbar
     */
    public static function createFromFieldset($definition)
    {
        $definition = self::parseDefinition($definition);
        $root       = new Group();
        $group      = $root;

        /** @var bool|Dropdown $dropdown */
        $dropdown = false;
        $first    = true;

        foreach ($definition as $button) {
            // dont add empty items
            if (self::isInvalidDefinition($button)) {
                continue;
            }

            // encode value
            $button = self::encodeValue($button);

            // finish dropdown
            if (self::hasToCloseDropdown($dropdown, $button)) {
                $dropdown = false;
            }

            if (in_array($button['type'], array('group', 'vgroup'))) {
                // create new group
                $group = self::createNewGroup($root, $button, $dropdown, !$first);
            } elseif ($button['type'] == 'dropdown') {
                // create dropdown

                $dropdown      = static::createDropdown($button['label'], $button['attributes'], true);
                $dropdownGroup = static::createGroup();
                $dropdownGroup->addChild($dropdown);

                $group->addChild($dropdownGroup);
            } elseif ($button['type'] == 'child' || $button['type'] == 'header') {
                // add dropdown child

                static::parseDropdownChild($dropdown, $button);
            } elseif ($dropdown !== false) {
                $child = static::createDropdownItem($button['label'], $button['url'], $button['attributes'], true);
                $dropdown->addChild($child);
            } else {
                $child = static::createButton($button['label'], $button['url'], $button['attributes'], true);
                $group->addChild($child);
            }

            $first = false;
        }

        return $root;
    }

    /**
     * Create a button.
     *
     * @param string $label        Button label.
     * @param string $url          Button href url.
     * @param array  $attributes   Additional html attributes.
     * @param bool   $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     *
     * @return Button
     */
    public static function createButton($label, $url, array $attributes = array(), $fromFieldset = false)
    {
        $button = new Button();
        $button->setLabel($label);
        static::applyAttributes($button, $attributes, $fromFieldset);
        $button->setAttribute('href', $url);

        return $button;
    }

    /**
     * Create button group.
     *
     * @param array $attributes   Additional html attributes.
     * @param bool  $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     * @param bool  $vertical     If true a vertical group is created.
     *
     * @return Group
     */
    public static function createGroup(array $attributes = array(), $fromFieldset = false, $vertical = false)
    {
        $group = new Group(array(), $vertical);
        static::applyAttributes($group, $attributes, $fromFieldset);

        return $group;
    }

    /**
     * Create button toolbar.
     *
     * @param array $attributes   Additional html attributes.
     * @param bool  $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     *
     * @return Toolbar
     */
    public static function createToolbar(array $attributes = array(), $fromFieldset = false)
    {
        $toolbar = new Toolbar();
        static::applyAttributes($toolbar, $attributes, $fromFieldset);

        return $toolbar;
    }

    /**
     * Create dropdown button.
     *
     * @param string $label        Dropdown button.
     * @param array  $attributes   Additional html attributes.
     * @param bool   $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     *
     * @return Dropdown
     */
    public static function createDropdown($label, array $attributes = array(), $fromFieldset = false)
    {
        $dropdown = new Dropdown();
        $dropdown->setLabel($label);

        static::applyAttributes($dropdown, $attributes, $fromFieldset);

        return $dropdown;
    }

    /**
     * Create dropdown header.
     *
     * @param string $label        Dropdown button.
     * @param array  $attributes   Additional html attributes.
     * @param bool   $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     *
     * @return Dropdown\Header
     */
    public static function createDropdownHeader($label, array $attributes = array(), $fromFieldset = false)
    {
        $dropdown = new Dropdown\Header();
        $dropdown->setLabel($label);

        static::applyAttributes($dropdown, $attributes, $fromFieldset);

        return $dropdown;
    }

    /**
     * Create dropdown divider.
     *
     * @param array $attributes   Additional html attributes.
     * @param bool  $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     *
     * @return Dropdown\Divider
     */
    public static function createDropdownDivider(array $attributes = array(), $fromFieldset = false)
    {
        $dropdown = new Dropdown\Divider();
        static::applyAttributes($dropdown, $attributes, $fromFieldset);

        return $dropdown;
    }

    /**
     * Create dropdown item.
     *
     * @param string $label        Dropdown label.
     * @param string $url          Dropdown url.
     * @param array  $attributes   Additional html attributes.
     * @param bool   $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     *
     * @return Dropdown\Item
     */
    public static function createDropdownItem($label, $url, array $attributes = array(), $fromFieldset = false)
    {
        $button = static::createButton($label, $url, $attributes, $fromFieldset);
        $button->setAttribute('role', 'menuitem');
        $dropdown = new Dropdown\Item($button);

        return $dropdown;
    }

    /**
     * Apply attributes.
     *
     * @param Attributes $node         Attrbiutes alement.
     * @param array      $attributes   Html attributes which being applied.
     * @param bool       $fromFieldset Set true if attributes comes from fieldset definitions have to be transformed.
     *
     * @return void
     */
    protected static function applyAttributes(Attributes $node, array $attributes, $fromFieldset = false)
    {
        if (empty($attributes)) {
            return;
        }

        if ($fromFieldset) {
            foreach ($attributes as $attribute) {
                if ($attribute['name']) {
                    if ($attribute['name'] == 'class') {
                        if (!$attribute['value']) {
                            return;
                        }

                        $attribute['value'] = explode(' ', $attribute['value']);
                    }
                    $node->setAttribute($attribute['name'], $attribute['value']);
                }
            }
        } else {
            foreach ($attributes as $name => $value) {
                if ($name) {
                    $node->setAttribute($name, $value);
                }
            }
        }
    }

    /**
     * Enable the toolbar.
     *
     * @param mixed $root Current root element.
     *
     * @return Toolbar
     */
    protected static function enableToolbar($root)
    {
        if (!$root instanceof Toolbar) {
            $group = $root;
            $root  = static::createToolbar(array(), true);

            if ($group instanceof Group && $group->getChildren()) {
                $root->addChild($group);
            }
        }

        return $root;
    }

    /**
     * Parse dropdown child.
     *
     * @param Dropdown|bool $dropdown Current dropdown element.
     * @param array         $button   Button definition.
     *
     * @return void
     */
    private static function parseDropdownChild($dropdown, $button)
    {
        if ($dropdown === false || !$dropdown instanceof Dropdown) {
            // @codingStandardsIgnoreStart
            // TODO throw exception?
            // @codingStandardsIgnoreEnd
            return;
        }

        if ($button['type'] == 'child') {
            $child = static::createDropdownItem($button['label'], $button['url'], $button['attributes'], true);
        } else {
            if ($dropdown->getChildren()) {
                $child = static::createDropdownDivider();
                $dropdown->addChild($child);
            }

            $child = static::createDropdownHeader($button['label'], $button['attributes'], true);
        }

        $dropdown->addChild($child);
    }

    /**
     * Parse button definition.
     *
     * @param string|array $definition Button definition.
     *
     * @return array
     */
    protected static function parseDefinition($definition)
    {
        if (!is_array($definition)) {
            $definition = deserialize($definition, true);

            return $definition;
        }

        return $definition;
    }

    /**
     * Consider if definition is invalid.
     *
     * @param array $button Button definition.
     *
     * @return bool
     */
    protected static function isInvalidDefinition($button)
    {
        return $button['label'] == '' && !in_array($button['type'], array('group', 'vgroup', 'dropdown'));
    }

    /**
     * Encode button value.
     *
     * @param array $button Button definition.
     *
     * @return button
     */
    protected static function encodeValue($button)
    {
        if (isset($button['button']) && $button['button'] == 'link') {
            if (substr($button['value'], 0, 7) == 'mailto:') {
                $button['value'] = \String::encodeEmail($button['value']);
            } else {
                $button['value'] = ampersand($button['value']);
            }
        }

        return $button;
    }

    /**
     * Create a new group element.
     *
     * @param mixed         $root      Current root.
     * @param array         $button    Button definition.
     * @param Dropdown|bool $dropdown  Dropdown element.
     * @param bool          $addToRoot If rue the created group is added to the root.
     *
     * @return Group
     */
    protected static function createNewGroup(&$root, $button, &$dropdown, $addToRoot = true)
    {
        if ($addToRoot) {
            $root = self::enableToolbar($root);
        }

        if ($dropdown !== false) {
            $dropdown = false;
        }

        $group = static::createGroup($button['attributes'], true, ($button['type'] === 'vgroup'));

        if ($addToRoot) {
            $root->addChild($group);
        } else {
            $root = $group;
        }

        return $group;
    }

    /**
     * Check if dropdown has to be closed.
     *
     * @param Dropdown|bool $dropdown Dropdown element.
     * @param array         $button   Button definition.
     *
     * @return bool
     */
    protected static function hasToCloseDropdown($dropdown, $button)
    {
        return $dropdown !== false && ($button['type'] != 'child' && $button['type'] != 'header');
    }
}
