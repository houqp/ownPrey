<?php
/**
* ownCloud - ownPrey App
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

namespace OCA\ownPrey\Db;

use \OCA\AppFramework\Core\API;
use \OCA\AppFramework\Db\Mapper;
use \OCA\AppFramework\Db\DoesNotExistException;


class DeviceMapper extends Mapper {


	private $tableName;


	/**
	 * @param API $api: Instance of the API abstraction layer
	 */
	public function __construct($api){
		parent::__construct($api);
		$this->tableName = '*PREFIX*ownprey_device';
	}


	/**
	 * Finds a device by id
	 * @throws DoesNotExistException: if the device does not exist
	 * @return the device
	 */
	public function find($id){
		$sql = 'SELECT * FROM `' . $this->tableName
				. '` WHERE `id` = ?';
		$row = $this->execute($sql, array($id))->fetchRow();
		if ($row) {
			return new Device($row);
		} else {
			throw new DoesNotExistException(
				'Device with id ' . $id . ' does not exist!');
		}
	}


	/**
	 * Finds a device by name
	 * @param string $dev_name: the name of the device that we want to find
	 * @throws DoesNotExistException: if the device does not exist
	 * @return the array of device with the same name
	 */
	public function findByDeviceName($dev_name){
		$sql = 'SELECT * FROM `' . $this->tableName
				. '` WHERE `name` = ?';
		$params = array($dev_name);
		$rows = $this->execute($sql, $params)->fetchRow();

		if ($rows) {
			$devs = array();
			foreach ($rows as $row) {
				array_push($devs, new Device($row));
			}
			return $devs;
		} else {
			throw new DoesNotExistException(
				'Device with name ' . $dev_name . ' does not exist!');
		}
	}


	/**
	 * Finds all Devices
	 * @return array containing all devices
	 */
	public function findAll(){
		$result = $this->findAllQuery($this->tableName);

		$entityList = array();
		while($row = $result->fetchRow()){
			$entity = new Device($row);
			array_push($entityList, $entity);
		}

		return $entityList;
	}


	/**
	 * Saves a device into the database
	 * @param Device $device: the device to be saved
	 * @return the device with the filled in id
	 */
	public function save($device){
		$sql = 'INSERT INTO `'
			. $this->tableName.'`'
			. ' (`id`, `name`, `missing`, `delay`, `module_list`)'
			.' VALUES(?, ?, ?, ?, ?)';

		$new_id = substr(md5(rand()), 0, 18);
		$params = array(
			$new_id,
			$device->getName(),
			$device->getMissing(),
			$device->getDelay(),
			$device->getModuleList()
		);

		$this->execute($sql, $params);

		$device->setId($new_id);
	}


	/**
	 * Updates a device
	 * @para Device $device: the device to be updated
	 */
	public function update($device){
		$sql = 'UPDATE `'. $this->tableName . '` SET
				`name` = ?,
				`missing` = ?,
				`delay` = ?
				`module_list` = ?
				WHERE `id` = ?';

		$params = array(
			$device->getName(),
			$device->getMissing(),
			$device->getDelay(),
			$device->getModuleList(),
			$device->getId()
		);

		$this->execute($sql, $params);
	}


	/**
	 * Deletes a device
	 * @param int $id: the id of th device
	 */
	public function remove($id){
		$this->deleteQuery($this->tableName, $id);
	}
}
