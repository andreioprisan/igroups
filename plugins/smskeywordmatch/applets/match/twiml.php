<?php
$body = isset($_REQUEST['Body'])? trim($_REQUEST['Body']) : null;
$body = strtolower($body);

$invalid_option = AppletInstance::getDropZoneUrl('invalid-option');
$keys = (array) AppletInstance::getValue('keys[]');
$responses = (array) AppletInstance::getDropZoneUrl('responses[]');
$menu_items = AppletInstance::assocKeyValueCombine($keys, $responses, 'strtolower');

$response = new TwimlResponse;

if(array_key_exists($body, $menu_items) && !empty($menu_items[$body]))
	$response->redirect($menu_items[$body]);
elseif(!empty($invalid_option))
	$response->redirect($invalid_option);

$response->respond();
