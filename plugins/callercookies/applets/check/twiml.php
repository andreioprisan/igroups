<?php
$number = normalize_phone_to_E164($_REQUEST['From']);
$cookies = PluginData::get('cookies'.$number, new stdClass());

$name = AppletInstance::getValue('name');
$value = AppletInstance::getValue('value');
$continue = false;

if(!is_null($name)&&($value==$cookies->$name||('not null'==strtolower($value)&&isset($cookies->$name))||('null'==strtolower($value)&&!isset($cookies->$name))))
	$continue = true;

$response = new Response();

if($continue){
	$pass = AppletInstance::getDropZoneUrl('pass');
	if(!empty($pass))
		$response->addRedirect($pass);
}
else{
	$fail = AppletInstance::getDropZoneUrl('fail');
	if(!empty($fail))
		$response->addRedirect($fail);
}

$response->Respond();
