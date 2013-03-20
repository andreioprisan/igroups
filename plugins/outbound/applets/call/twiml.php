<?php
$ci =& get_instance();
$number = AppletInstance::getValue('number');
$id = AppletInstance::getValue('flow');

if(!empty($_REQUEST['From'])) {
	$recipient = normalize_phone_to_E164(str_replace('%sender%', $_REQUEST['From'], AppletInstance::getValue('recipient')));
  require_once(APPPATH . 'libraries/Services/Twilio.php');
  $service = new Services_Twilio($ci->twilio_sid, $ci->twilio_token);
	if(($flow = OpenVBX::getFlows(array('id' => $id, 'tenant_id' => $ci->tenant->id))) && $flow[0]->values['data'])
	  $service->account->calls->create($number, $recipient, site_url('twiml/start/voice/' . $id));
}

$response = new TwimlResponse;

$next = AppletInstance::getDropZoneUrl('next');
if(!empty($next))
	$response->redirect($next);

$response->respond();
