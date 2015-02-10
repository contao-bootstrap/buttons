<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_buttons'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons'],
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'default'   => array
    (
        array
        (
            'type'       => 'button',
            'label'      => $GLOBALS['TL_LANG']['MSC']['close'],
            'attributes' => array(
                array('name' => 'data-dismiss', 'value' => 'modal')
            ),
        ),
        array('type' => 'button'),
    ),
    'eval'      => array(
        'tl_class'       => 'bootstrapMultiColumnWizard hideSubLabels clr long',
        'decodeEntities' => true,
        'columnFields'   => array
        (
            'type'       => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_type'],
                'exclude'   => true,
                'inputType' => 'select',
                'options'   => array('link', 'group', 'dropdown', 'child', 'header'),
                'reference' => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_types'],
                'eval'      => array(
                    'style'  => 'width: 90px;',
                    'valign' => 'top',
                    'chosen' => true,
                ),
            ),
            'label'      => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_label'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => array('style' => 'width: 90px', 'valign' => 'top', 'allowHtml' => true,),
            ),
            'url'        => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_url'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => array(
                    'style'          => 'width: 90px',
                    'valign'         => 'top',
                    'rgxp'           => 'url',
                    'decodeEntities' => true,
                    'tl_class'       => 'wizard'
                ),
                'wizard'    => array
                (
                    array('Netzmacht\Bootstrap\Core\Contao\DataContainer\Module', 'pagePicker')
                ),
            ),
            'attributes' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_attributes'],
                'exclude'   => true,
                'inputType' => 'multiColumnWizard',
                'options'   => array('data-dismiss="modal"', 'class="btn-default"'),
                'eval'      => array
                (

                    'decodeEntities' => true,
                    'columnFields'   => array
                    (
                        'name'  => array
                        (
                            /*'inputType' => 'customselect',*/
                            'inputType' => 'text',
                            'options'   => array('class', 'title', 'data-dismiss'),
                            'exclude'   => true,
                            'eval'      => array
                            (
                                'style'       => 'width: 80px;',
                                'placeholder' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_attributes_name'],
                            ),
                        ),
                        'value' => array
                        (
                            'inputType' => 'text',
                            'exclude'   => true,
                            'eval'      => array
                            (
                                'style'       => 'width: 130px',
                                'placeholder' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_attributes_value']
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'sql'       => "blob NULL"
);
