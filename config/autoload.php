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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'NC' ,
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'NC\NcNotifyAdministrator' => 'system/modules/nc_registration_notify_admin/classes/NcNotifyAdministrator.php' ,
));