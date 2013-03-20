<?php
$number = normalize_phone_to_E164($_REQUEST['From']);
$cookies = PluginData::get('cookies'.$number, new stdClass());

$text = AppletInstance::getValue('text');

if(preg_match_all('/(%([^%]+)%)/', $text, $matches)){
	$search = $matches[1];
	$replace = array();
	foreach($matches[2] as $name)
		$replace[]=$cookies->$name;
	$text = str_replace($search, $replace, $text);
}

$response = new Response();

if(AppletInstance::getFlowType() == 'voice')
	$response->addSay($text);
else
	$response->addSms($text);

$next = AppletInstance::getDropZoneUrl('next');
if(!empty($next))
	$response->addRedirect($next);

$response->Respond();
