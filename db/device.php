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


class Device {

	private $id;
	private $name;
	private $missing;
	private $delay;
	private $module_list;

	public function __construct($fromRow=null) {
		if($fromRow){
			$this->fromRow($fromRow);
		}
	}

	public function fromRow($row) {
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->missing = $row['missing'];
		$this->delay = $row['delay'];
		$this->module_list = $row['module_list'];
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getMissing() {
		return $this->missing;
	}

	public function getDelay() {
		return $this->delay;
	}

	public function getModuleList() {
		return $this->module_list;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setMissing($missing) {
		$this->missing = $missing;
	}

	public function setDelay($delay) {
		$this->delay = $delay;
	}

	public function setModuleList($module_list) {
		$this->module_list = $module_list;
	}
}
