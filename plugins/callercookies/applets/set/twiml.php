<?php
$number = normalize_phone_to_E164($_REQUEST['From']);
$cookies = PluginData::get('cookies'.$number, new stdClass());

$names = (array) AppletInstance::getValue('names[]');
$values = (array) AppletInstance::getValue('values[]');

foreach($names as $i => $name)
	if($name){
		if('%body%'==$values[$i])
			$values[$i]=$_REQUEST['Body'];
		elseif(preg_match('/%([^%]+)%/', $values[$i], $match))
			$values[$i]=$cookies->$match[1];
		if(''!=$values[$i])
			$cookies->$name=$values[$i];
		else
			unset($cookies->$name);
	}

PluginData::set('cookies'.$number, $cookies);

$response = new Response();

$next = AppletInstance::getDropZoneUrl('next');
if(!empty($next))
	$response->addRedirect($next);

$response->Respond();
