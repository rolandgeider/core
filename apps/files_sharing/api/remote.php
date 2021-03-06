<?php
/**
 * @author Joas Schilling <nickvergessen@owncloud.com>
 *
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\Files_Sharing\API;

use OC\Files\Filesystem;
use OCA\Files_Sharing\External\Manager;

class Remote {

	/**
	 * Accept a remote share
	 *
	 * @param array $params contains the shareID 'id' which should be accepted
	 * @return \OC_OCS_Result
	 */
	public static function getOpenShares($params) {
		$externalManager = new Manager(
			\OC::$server->getDatabaseConnection(),
			Filesystem::getMountManager(),
			Filesystem::getLoader(),
			\OC::$server->getHTTPHelper(),
			\OC_User::getUser()
		);

		return new \OC_OCS_Result($externalManager->getOpenShares());
	}

	/**
	 * Accept a remote share
	 *
	 * @param array $params contains the shareID 'id' which should be accepted
	 * @return \OC_OCS_Result
	 */
	public static function acceptShare($params) {
		$externalManager = new Manager(
			\OC::$server->getDatabaseConnection(),
			Filesystem::getMountManager(),
			Filesystem::getLoader(),
			\OC::$server->getHTTPHelper(),
			\OC_User::getUser()
		);

		if ($externalManager->acceptShare($params['id'])) {
			return new \OC_OCS_Result();
		}

		return new \OC_OCS_Result(null, 404, "wrong share ID, share doesn't exist.");
	}

	/**
	 * Decline a remote share
	 *
	 * @param array $params contains the shareID 'id' which should be declined
	 * @return \OC_OCS_Result
	 */
	public static function declineShare($params) {
		$externalManager = new Manager(
			\OC::$server->getDatabaseConnection(),
			Filesystem::getMountManager(),
			Filesystem::getLoader(),
			\OC::$server->getHTTPHelper(),
			\OC_User::getUser()
		);

		if ($externalManager->declineShare($params['id'])) {
			return new \OC_OCS_Result();
		}

		return new \OC_OCS_Result(null, 404, "wrong share ID, share doesn't exist.");
	}

}
