<?php
	$user = OpenVBX::getCurrentUser();
	$tenant_id = $user->values['tenant_id'];
	$ci =& get_instance();
	if(!empty($_POST['recipient'])) {
		$account = OpenVBX::getAccount();
		$id = intval($_POST['flow']);
		if(($flow = OpenVBX::getFlows(array('id' => $id, 'tenant_id' => $tenant_id))) && $flow[0]->values['data'])
			$account->calls->create($_POST['number'], normalize_phone_to_E164($_POST['recipient']), site_url('twiml/start/voice/' . $id));
	}
	$flows = OpenVBX::getFlows(array('tenant_id' => $tenant_id));
?>
<style>
	.vbx-outbound form {
		padding: 20px 5%;
	}
</style>
<div class="vbx-content-main">
	<div class="vbx-content-menu vbx-content-menu-top">
		<h2 class="vbx-content-heading">Start Flow</h2>
	</div>
    <div class="vbx-table-section vbx-outbound">
		<form method="post" action="">
			<fieldset class="vbx-input-container">
<?php if(count($callerid_numbers)): ?>
				<p>
					<label class="field-label">Number<br/>
						<input type="text" name="recipient" class="medium" />
					</label>
				</p>
<?php if(count($flows)): ?>
				<p>
					<label class="field-label">Flow<br/>
						<select name="flow" class="medium">
<?php foreach($flows as $flow): ?>
							<option value="<?php echo $flow->values['id']; ?>"><?php echo $flow->values['name']; ?></option>
<?php endforeach; ?>
						</select>
					</label>
				</p>
				<p>
					<label class="field-label">Caller ID<br/>
						<select name="number" class="medium">
<?php foreach($callerid_numbers as $number): ?>
							<option value="<?php echo $number->phone; ?>"><?php echo $number->name; ?></option>
<?php endforeach; ?>
						</select>
					</label>
				</p>
				<p><button type="submit" class="submit-button"><span>Call</span></button></p>
<?php else: ?>
				<p>You do not have any flows!</p>
<?php endif; ?>
<?php else: ?>
				<p>You do not have any phone numbers!</p>
<?php endif; ?>
			</fieldset>
		</form>
    </div>
</div>
