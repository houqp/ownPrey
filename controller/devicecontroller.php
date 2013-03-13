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

namespace OCA\ownPrey\Controller;

use OCA\AppFramework\Controller\Controller;
use OCA\AppFramework\Db\DoesNotExistException;

use OCA\AppFramework\Http\Response;
use OCA\AppFramework\Http\TemplateResponse;
use OCA\AppFramework\Http\TextResponse;

use OCA\ownPrey\Db\Device;


class DeviceController extends Controller {
	public function __construct($api, $request, $dev_mapper) {
		parent::__construct($api, $request);
		$this->deviceMapper = $dev_mapper;
	}

	/**
	 * @CSRFExemption
	 * @IsAdminExemption
	 * @IsSubAdminExemption
	 *
	 * @brief renders the index page
	 * @return an instance of a Response implementation
	 */
	public function index() {
		$this->api->addStyle('style');
		$this->api->addScript('app');

		$templateName = 'main';
		$params = array('devices' => array());
		foreach ($this->deviceMapper->findAll() as $dev) {
			array_push($params['devices'], array(
				'id' => $dev->getId(),
				'name' => $dev->getName(),
				'missing' => $dev->getMissing(),
				'delay' => $dev->getDelay(),
				'module_list' => $dev->getModuleList(),
			));
		}

		return $this->render($templateName, $params);
	}

	/**
	 * @CSRFExemption
	 * @IsAdminExemption
	 * @IsSubAdminExemption
	 * @IsLoggedInExemption
	 * @Ajax
	 */
	public function check() {
		$dev = $this->deviceMapper->find($this->params('id'));

		if ($dev) {
			$device = new \SimpleXMLElement('<device/>');

			$status = $device->addChild('status');
			$missing = $status->addChild('missing', $dev->getMissing());

			$configuration = $device->addChild('configuration');
			$configuration->addChild('delay', $dev->getDelay());

			$modules = $device->addChild('modules');
			foreach (explode(' ', $dev->getModuleList()) as $mod) {
				$m = $modules->addChild('module');
				$m->addAttribute('active', 'true');
				$m->addAttribute('name', $mod);
				$m->addAttribute('type', 'report');
				$m->addChild('enabled', 'true');
			}

			$response = new TextResponse($device->asXML(), 'xml');

			if ($missing == "true") {
				$response->addHeader('HTTP/1.1: 404 Not Found');
			}
		} else {
			$response = new Response();
			$response->addHeader('HTTP/1.1: 400 Bad Request');
		}

		return $response;
	}

	/**
	 * @CSRFExemption
	 * @IsAdminExemption
	 * @IsSubAdminExemption
	 * @Ajax
	 */
	public function findAll() {
		$dev_array = array();

		foreach ($this->deviceMapper->findAll() as $dev) {
			array_push($dev_array, array(
				'id' => $dev->getId(),
				'name' => $dev->getName(),
				'missing' => $dev->getMissing(),
				'delay' => $dev->getDelay(),
				'module_list' => $dev->getModuleList(),
			));
		}

		return $this->renderJSON($dev_array);
	}

	/**
	 * @CSRFExemption
	 * @IsAdminExemption
	 * @IsSubAdminExemption
	 * @Ajax
	 */
	public function addDevice() {
		$dev = new Device();
		$dev->setName(trim($this->params('name')));
		$dev->setMissing(trim($this->params('missing')));
		$dev->setDelay(trim($this->params('delay')));
		$dev->setModuleList(trim($this->params('module_list')));

		/* save call will also set device id */
		$this->deviceMapper->save($dev);
		/* return new id to web interface */
		$res_array = array(
			'status' => 'failure',
			'id' => null,
		);

		if ($dev->getId()) {
			$res_array['status'] = 'success';
			$res_array['id'] = $dev->getId();
		}

		return $this->renderJSON($res_array);
	}

	/**
	 * @CSRFExemption
	 * @IsAdminExemption
	 * @IsSubAdminExemption
	 * @Ajax
	 */
	public function updateDevice() {
		$dev = new Device();
		$dev->setId($this->params('id'));
		$dev->setName(trim($this->params('name')));
		$dev->setMissing(trim($this->params('missing')));
		$dev->setDelay(trim($this->params('delay')));
		$dev->setModuleList(trim($this->params('module_list')));

		$res_array = array(
			'status' => 'success',
		);

		//@TODO how can we detect failure here?    (houqp)
		$this->deviceMapper->update($dev);

		return $this->renderJSON($res_array);
	}

	/**
	 * @CSRFExemption
	 * @IsAdminExemption
	 * @IsSubAdminExemption
	 * @Ajax
	 */
	public function removeDevice() {
		$response = new Response();

		$this->deviceMapper->remove($this->params('id'));

		return $response;
	}
}

