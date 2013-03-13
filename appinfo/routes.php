<?php
/**
* ownCloud - App Template Example
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

namespace OCA\ownPrey;

use OCA\AppFramework\App;

use OCA\ownPrey\DependencyInjection\DIContainer;
use OCA\ownPrey\Db\DeviceMapper;


/**
 * Normal Routes
 */
$this->create('ownprey_index', '/')->action(
	function($params) {
		App::main('DeviceController', 'index',
			$params, new DIContainer());
	}
);

/**
 * Ajax Routes
 */
$this->create('ownprey_device_check', '/check/{id}')->action(
	function($params) {
		App::main('DeviceController', 'check',
			$params, new DIContainer());
	}
);

$this->create('ownprey_device_get_all', '/device')->get()->action(
	function($params) {
		App::main('DeviceController', 'findAll',
			$params, new DIContainer());
	}
);

$this->create('ownprey_device_add', '/device')->post()->action(
	function($params) {
		App::main('DeviceController', 'addDevice',
			$params, new DIContainer());
	}
);

$this->create('ownprey_device_update', '/device/{id}')->post()->action(
	function($params) {
		App::main('DeviceController', 'updateDevice',
			$params, new DIContainer());
	}
);

$this->create('ownprey_device_remove', '/device/{id}')->delete()->action(
	function($params) {
		App::main('DeviceController', 'removeDevice',
			$params, new DIContainer());
	}
);
