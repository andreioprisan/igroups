<?php
$response = new Response();

/* Fetch all the data to operate the router */
$keys = AppletInstance::getValue('keys');
$invalid = AppletInstance::getDropZoneUrl('invalid');

$selected_item = false;

/* Build Menu Items */
$choices = AppletInstance::getDropZoneUrl('choices[]');
$keys = AppletInstance::getDropZoneValue('keys[]');
$router_items = AppletInstance::assocKeyValueCombine($keys, $choices);

// Change this to From or callerid
if(isset($_REQUEST['From']) && array_key_exists($_REQUEST['From'], $router_items))
{
	// change this to caller id
	$routed_path = $router_items[$_REQUEST['From']];
	$response->addRedirect($routed_path);
	$response->Respond();
	exit;
}
else if(isset($_REQUEST['Caller']) && array_key_exists($_REQUEST['Caller'], $router_items))
{
	// change this to caller id
	$routed_path = $router_items[$_REQUEST['Caller']];
	$response->addRedirect($routed_path);
	$response->Respond();
	exit;
}
else
{

	if(!empty($invalid))
	{
	    $response->addRedirect($invalid);    
		$response->Respond();
		exit;
	}
	else
	{	 
		$response->Respond();
		exit;
	}		
}