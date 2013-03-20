<?php
/**
 * "The contents of this file are subject to the Mozilla Public License
 *  Version 1.1 (the "License"); you may not use this file except in
 *  compliance with the License. You may obtain a copy of the License at
 *  http://www.mozilla.org/MPL/

 *  Software distributed under the License is distributed on an "AS IS"
 *  basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 *  License for the specific language governing rights and limitations
 *  under the License.

 *  The Original Code is OpenVBX, released June 15, 2010.

 *  The Initial Developer of the Original Code is Twilio Inc.
 *  Portions created by Twilio Inc. are Copyright (C) 2010.
 *  All Rights Reserved.

 * Contributor(s):
 **/

class PhoneresourcesException extends Exception {}
class Phoneresources extends MY_Model {

	protected static $__CLASS__ = __CLASS__;
	public $table = 'phone_resources';

	public function __construct($object = null)
	{
		parent::__construct($object);
	}

	/**
	 * return phone resources information for the current user
	 *
	 * @param int $user_id
	 * @return object
	 */
	public static function get($tenant_id)
	{
		$ci = &get_instance();
		$result = $ci->db
			->from('phone_resources')
			->where('tenant_id', $tenant_id)
			->get()->result();

		return $result[0];
	}
}
