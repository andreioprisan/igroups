<?php
	$ci =& get_instance();
	if(defined("HOOK") AND HOOK) {
		set_time_limit(0);
		$events = $ci->db->query(sprintf('SELECT id, tenant, number, type, time, callerId, data FROM outbound_queue WHERE time < %d ORDER BY time ASC', time()))->result();
		if(count($events)) {
			require_once(APPPATH . 'libraries/Services/Twilio.php');
			foreach($events as $event) {
				$event->data = json_decode($event->data);
				$twilio_sid = $ci->settings->get('twilio_sid', $event->tenant);
				$twilio_token = $ci->settings->get('twilio_token', $event->tenant);
				$service = new Services_Twilio($twilio_sid, $ci->twilio_token);
				if('sms' == $event->type)
				  $service->account->sms_messages->create($event->callerId, $event->number, $event->data->message);
				else
				  $service->account->calls->create($event->callerId, $event->number, site_url('twiml/start/voice/' . $event->data->id));
				 $ci->db->delete('outbound_queue', array('id' => $event->id));
			}
		}
		die;
	}
	$user = OpenVBX::getCurrentUser();
	$tenant_id = $user->values['tenant_id'];
	$queries = explode(';', file_get_contents(dirname(__FILE__) . '/db.sql'));
	foreach($queries as $query)
		if(trim($query))
			$ci->db->query($query);
	if(!empty($_POST['remove'])) {
		$ci->db->delete('outbound_queue', array('id' => intval($_POST['remove']), 'tenant' => $tenant_id));
		die;
	}
	$events = $ci->db->query(sprintf('SELECT id, number, type, time, callerId, data FROM outbound_queue WHERE tenant=%d ORDER BY time ASC', $tenant_id))->result();
	OpenVBX::addJS('queue.js');
?>
<style>
	.vbx-queue h3 {
		font-size: 16px;
		font-weight: bold;
		margin-top: 0;
	}
	.vbx-queue .event {
		clear: both;	
		width: 95%;
		overflow: hidden;
		margin: 0 auto;
		padding: 5px 0;
		border-bottom: 1px solid #eee;
	}
	.vbx-queue .event span {
		display: inline-block;
		width: 20%;
		text-align: center;
		float: left;
		vertical-align: middle;
		line-height: 24px;
	}
	.vbx-queue a.delete {
		display: inline-block;
		height: 24px;
		width: 24px;
		text-indent: -999em;
		background: transparent url(/assets/i/action-icons-sprite.png) no-repeat -68px 0;
	}
</style>
<div class="vbx-content-main">
	<div class="vbx-content-menu vbx-content-menu-top">
		<h2 class="vbx-content-heading">Scheduled Events</h2>
	</div>
	<div class="vbx-table-section vbx-queue">
		<div class="event">
			<h3>
				<span>Number</span>
				<span>Type</span>
				<span>Time</span>
				<span>Caller ID</span>
				<span>Delete</span>
			</h3>
		</div>
<?php foreach($events as $event): $event->data = json_decode($event->data); ?>
		<div class="event" id="event_<?php echo $event->id; ?>">
			<p>
				<span><?php echo $event->number; ?></span>
<?php if('sms' == $event->type): ?>
				<span title="<?php echo htmlentities($event->data->message); ?>">SMS</span>
<?php else: ?>
				<span><?php echo htmlentities($event->data->name); ?></span>
<?php endif; ?>
				<span><?php echo date('j-M-Y g:i:sa', $event->time); ?></span>
				<span><?php echo $event->callerId; ?></span>
				<span><a href="" class="delete">X</a></span>
			</p>
		</div>
<?php endforeach; ?>
	</div>
</div>
