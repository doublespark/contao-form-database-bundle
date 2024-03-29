<?php

use Contao\DC_Table;
use Contao\Backend;
use Contao\DataContainer;

/**
 * Table tl_form_db
 */
$GLOBALS['TL_DCA']['tl_form_db'] = array
(

	// Config
	'config' => array
	(
		'dataContainer' => DC_Table::class,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
        'closed' => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'flag'                    => 8,
			'fields'                  => array('submitted_date'),
			'panelLayout'             => 'filter;sort,search,limit',
			'disableGrouping'         => false
		),
		'label' => array
		(
			'fields'                  => array('form_name'),
			'format'                  => '%s',
            'label_callback'          => array('tl_form_db', 'getListLabel')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
			),
			'show' => array
			(
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default' => 'submitted_date,form_name,form_data',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'submitted_date' => array
        (
            'default'                 => time(),
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'mandatory'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'form_name' => array
		(
			'search'                  => true,
			'inputType'               => 'text',
			'sql'                     => "varchar(155) NOT NULL default ''"
		),
        'form_data' => array
        (
            'sql'                     => "text NULL",
            'input_field_callback'    => array('tl_form_db', 'formDataField')
        ),
	)
);

/**
 * Class tl_form_db
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_form_db extends Backend
{
    /**
     * Generate label for the Contao backend list
     * @param  Array $arrData
     * @return String
     */
    public function getListLabel($arrData)
    {
        $submitted = date('d/m/Y H:i', $arrData['submitted_date']);

        $formData = json_decode($arrData['form_data'],true);

        $email = '';

        if(is_array($formData))
        {
            foreach($formData as $field => $value)
            {
                if(in_array(strtolower($field),['email','e-mail']))
                {
                    $email = ' - '.$value;
                    break;
                }
            }
        }

        $label = '<span style="color:#CCC;">['.$submitted.']</span> '.$arrData['form_name'].$email;

        return $label;
    }

    public function formDataField(DataContainer $dc)
    {
        $formData = json_decode($dc->activeRecord->form_data,true);

        $html = '<p>No form data to show</p>';

        if(is_array($formData))
        {
            $html = '<table id="formdata" cellpadding="0" cellspacing="0" width="100%">';
            $html .= '<tr><th width="200">Field</th><th>Value</th></tr>';
            foreach($formData as $field => $value)
            {
                $html .= '<tr><td>'.$field.'</td><td>'.$value.'</td></tr>';
            }
            $html .= '</table><style>#formdata td, #formdata th { padding:10px; border:1px solid #CCC; border-collapse: collapse; }</style>';
        }

        return '<div class="widget" style="padding-top:15px;"><h2 style="padding-bottom:5px;">Form data</h2>'.$html.'</div>';
    }
}