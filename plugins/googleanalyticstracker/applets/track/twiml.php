<?php
$account = AppletInstance::getValue('account');
$url = AppletInstance::getValue('url');
$title = AppletInstance::getValue('title');
$next = AppletInstance::getDropZoneUrl('next');

if(!empty($_REQUEST['From'])) {
    $from = normalize_phone_to_E164($_REQUEST['From']);
    $to = normalize_phone_to_E164($_REQUEST['To']);
    $url = str_replace(array('%caller%', '%number%'), array($from, $to), $url);
    $title = str_replace(array('%caller%','%number%'), array($from, $to), $title);

    include_once('Galvanize.php');
    @$GA = new Galvanize($account);
    @$GA->trackPageView($url, $title);
}

$response = new TwimlResponse;

if(!empty($next))
	$response->redirect($next);

$response->respond();
