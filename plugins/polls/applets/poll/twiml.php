<?php
$ci =& get_instance();
$poll = AppletInstance::getValue('poll');
$option = AppletInstance::getValue('option');

if(!empty($_REQUEST['From'])) {
	$number = normalize_phone_to_E164($_REQUEST['From']);
	$ci->db->delete('polls_responses', array('poll' => $poll, 'value' => $number));
	$ci->db->insert('polls_responses', array(
		'poll' => $poll,
		'value' => $number,
		'response' => $option,
		'time' => time()
	));
}

$response = new TwimlResponse;

$next = AppletInstance::getDropZoneUrl('next');
if(!empty($next))
	$response->redirect($next);

$response->respond();
