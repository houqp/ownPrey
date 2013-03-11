<?php

/**
* ownCloud - ownPrey
*
* @author Qingping Hou
* @copyright 2012 Qingping Hou qingping.hou@gmail.com
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/

namespace OCA\ownPrey\AppInfo;


\OCP\App::addNavigationEntry( array(

	/* the string under which your app will be referenced
	 * in owncloud, for instance: \OC_App::getAppPath('APP_ID') */
	'id' => 'ownprey',

	'order' => 4,

	/* the route that will be shown on startup */
	'href' => \OC_Helper::linkToRoute('ownprey_index'),

	/* the title of your application. This will be used in the
	 * navigation or on the settings page of your app */
	'name' => \OC_L10N::get('ownprey')->t('ownPrey')

));
