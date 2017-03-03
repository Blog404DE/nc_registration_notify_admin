<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package		NC Registration Admin Notification
 * @author		Marcel Mathias Nolte <marcel.nolte@noltecomputer.de>
 * @author		Jens Dutzi <info@tf-network.de>
 * @copyright	Marcel Mathias Nolte 2015
 * @link		https://github.com/Blog404DE/nc_registration_notify_admin
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
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