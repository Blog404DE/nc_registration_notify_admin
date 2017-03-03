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
 * Run in a custom namespace, so the class can be replaced
 */
namespace NC;

/**
 * Class NcNotifyAdministrator
 *
 * Provide necessary callback functions.
 */
class NcNotifyAdministrator extends \Frontend
{

	/**
	 * Notifiy admin
	 * @param integer
	 * @param array
	 * @param object 
	 */
	public function informAdminCreate($intId, $arrData, $objModule)
	{
		if ($objModule->nc_registration_notify_admin)
		{
			$this->sendAdminNotification((object)$arrData, $GLOBALS['TL_LANG']['MSC']['registration_notify_admin_text']);
		}
	}
	
	
	/**
	 * Notifiy admin
	 * @param object
	 * @param object 
	 */
	public function informAdminActivate($objUser, \ModuleRegistration $objRegistration)
	{
		if ($objRegistration->nc_registration_notify_admin_activate)
		{
			$this->sendAdminNotification((object)$objUser[0]->row(), $GLOBALS['TL_LANG']['MSC']['registration_notify_admin_activate_text']);
		}
	}


	/**
	 * Send an admin notification e-mail
	 * @param object
	 */
	protected function sendAdminNotification($objUser, $text)
	{
		$objEmail = new \Email();
		$objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
		$objEmail->fromName = $GLOBALS['TL_ADMIN_NAME'];
		$objEmail->subject = sprintf($text, $objUser->id, '');
		$strData = "\n\n";
		foreach ($objUser as $k => $v)
		{
			if ($k == 'password' || $k == 'tstamp' || $k == 'activation' || trim($k) == '')
			{
				continue;
			}
			$v = deserialize($v);
			if ($k == 'dateOfBirth' && strlen($v))
			{
				$v = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $v);
			}
			$strData .= $GLOBALS['TL_LANG']['tl_member'][$k][0] . ': ' . (is_array($v) ? implode(', ', $v) : $v) . "\n";
		}
		$objEmail->text = sprintf($text, $objUser->id, $strData . "\n") . "\n";
		$objEmail->sendTo($GLOBALS['TL_ADMIN_EMAIL']);
		$this->log('An admin notification e-mail has been sent', 'NotifyAdmin sendAdminNotification()', TL_ACCESS);
	}
}