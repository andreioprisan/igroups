<?php
$body = isset($_REQUEST['Body'])? trim($_REQUEST['Body']) : null;

$keys = (array) AppletInstance::getValue('keys[]');
$responses = (array) AppletInstance::getDropZoneUrl('responses[]');
$menu_items = AppletInstance::assocKeyValueCombine($keys, $responses);
$next = AppletInstance::getDropZoneUrl('invalid-option');

$response = new TwimlResponse;

foreach($menu_items as $regex => $redirect)
	if(!empty($regex) && preg_match("/" . $regex . "/i", $body)) {
		$next = $redirect;
		break;
	}

if(!empty($next))
	$response->redirect($next);

$response->respond();
