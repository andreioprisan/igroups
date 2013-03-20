<?php
$response = new Response();

$redirect_type_selector = AppletInstance::getValue('redirect-type-selector');

if ($redirect_type_selector == "flow")
{
	$gotoflow_raw = AppletInstance::getValue('gotoflow');
	$gotoflow_url = site_url("/twiml/applet/voice/" . $gotoflow_raw . "/start");
	
	$response = new Response();
	$response->addRedirect($gotoflow_url);
	$response->Respond();
	exit;
}

else if ($redirect_type_selector == "url")
{
	$gotourl = AppletInstance::getValue('gotourl');
	$response = new Response();
	$response->addRedirect($gotourl);
	$response->Respond();
	exit;
}

else
{
	trigger_error("Unexpected redirect-type-selector value of '$redirect_type_selector'");
}