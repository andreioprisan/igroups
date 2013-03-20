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
	
class ErrorMessages
{
	public static $twilio_api = array(
		404 => 'iGroups authentication error. Is your account active?',
		401 => 'iGroups authentication error. Please contact iGroups at support@igrou.ps',
		400 => 'iGroups authentication error. Please contact iGroups at support@igrou.ps',
		500 => 'iGroups authentication error. Please contact iGroups at support@igrou.ps',
		503 => 'iGroups service unavailable due to network connectivity issues.',
	);

	public static function message($group, $code)
	{
		_deprecated_notice(__METHOD__, '1.2', 'Use Exception messages directly.');
		$message = null;
		$error_group = null;
		
		if(property_exists('ErrorMessages', $group))
		{
			$error_group = self::$$group;
		}
		
		if(is_array($error_group))
		{
			$message = isset($error_group[$code])? $error_group[$code] : "Unknown Error: $code";
		}
		
		if(is_null($message))
		{
			$message = 'Unknown Error';
		}

		return $message;
	}
}