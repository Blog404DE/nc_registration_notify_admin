<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   NC Registration Admin Notification 
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015
 * @website	  https://www.noltecomputer.com
 * @license   <marcel.nolte@noltecomputer.de> wrote this file. As long as you retain this notice you
 *            can do whatever you want with this stuff. If we meet some day, and you think this stuff 
 *            is worth it, you can buy me a beer in return. Meanwhile you can provide a link to my
 *            homepage, if you want, or send me a postcard. Be creative! Marcel Mathias Nolte
 */


/**
 *  Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['nc_registration_notify_admin'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['nc_registration_notify_admin'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'sql'                     => 'char(1) NOT NULL default \'\''
);
$GLOBALS['TL_DCA']['tl_module']['fields']['nc_registration_notify_admin_activate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['nc_registration_notify_admin_activate'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'sql'                     => 'char(1) NOT NULL default \'\''
);

$GLOBALS['TL_HOOKS']['loadDataContainer'][] = array('tl_module_registration_notify_administrator', 'extendPalettes');

/**
 * Class tl_module_registration_notify_administrator
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_module_registration_notify_administrator extends Backend
{

	/**
	 * Initialization and necessary imports
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	
	/**
	 * Extend the default palettes
	 * @param string
	 */
	public function extendPalettes($strName)
	{
		if ($strName != 'tl_module')
		{
			return;
		}
		$GLOBALS['TL_DCA']['tl_module']['subpalettes']['reg_activate'] = str_replace('reg_jumpTo,reg_text', 'reg_jumpTo,reg_text,nc_registration_notify_admin,nc_registration_notify_admin_activate', $GLOBALS['TL_DCA']['tl_module']['subpalettes']['reg_activate']);
	}
}