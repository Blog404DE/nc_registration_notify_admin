<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2016 Leo Feyer
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
class NcNotifyAdministrator extends \Frontend {

	/**
	 * Notifiy admin
	 * @param integer
	 * @param array
	 * @param object
	 */
	public function informAdminCreate($intId , $arrData, $objModule) {
		if ($objModule->nc_registration_notify_admin) {
			$this->sendAdminNotification((object)$arrData, $GLOBALS['TL_LANG']['MSC']['registration_notify_admin_text']);
		}
	}


	/**
	 * @param $objUser
	 * @param \ModuleRegistration $objRegistration
	 */
	public function informAdminActivate($objUser , \ModuleRegistration $objRegistration) {
		if ($objRegistration->nc_registration_notify_admin_activate) {
			$this->sendAdminNotification((object)$objUser->row(), $GLOBALS['TL_LANG']['MSC']['registration_notify_admin_activate_text']);
		}
	}


	/**
	 * Send an admin notification e-mail
	 * @param object
	 * @param string
	 */
	protected function sendAdminNotification($objUser , $text) {
		$objEmail = new \Email();
		$objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
		$objEmail->fromName = $GLOBALS['TL_ADMIN_NAME'];
		$objEmail->subject = sprintf($text , $objUser->lastname, $objUser->firstname, "");

		$hiddenFields = array('password', 'tstamp', 'activation', 'assignDir', 'homeDir', 'disable', 'start', 'stop', 'dateAdded', 'lastLogin', 'currentLogin', 'loginCount', 'locked', 'session', 'autologin', 'createdOn');

		$strData = "\n\n";
		foreach ($objUser as $k => $v) {
			if (in_array($k, $hiddenFields) || $v == "a:0:{}" || empty($v)) {
				continue;
			}

			$v = deserialize($v);
			if ($k == 'dateOfBirth' && strlen($v)) {
				$v = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'] , $v);
			}

			if(array_key_exists($k, $GLOBALS['TL_LANG']['tl_member'])) {
				$fieldname = $GLOBALS['TL_LANG']['tl_member'][$k][0];
			} else {
				$fieldname = $k;
			}

			$strData .= $fieldname . ': ' . (is_array($v) ? implode(', ' , $v) : $v) . "\n";
		}

		$objEmail->text = sprintf($text, $objUser->lastname, $objUser->firstname, $strData . "\n") . "\n";

		$objEmail->sendTo($GLOBALS['TL_ADMIN_EMAIL']);
		$this->log('An admin notification e-mail has been sent', 'NotifyAdmin sendAdminNotification()', TL_ACCESS);
	}
}