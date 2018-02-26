<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License (GPL) version 3
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/
 *
 * @author    Ve Interactive <info@veinteractive.com>
 * @copyright 2015 Ve Interactive
 * @license   http://www.gnu.org/licenses/ GNU General Public License (GPL) version 3
 */

class VePlatformTabController extends ModuleAdminController {

	public function renderList()
	{
		return $this->module->getContent();
	}

}
