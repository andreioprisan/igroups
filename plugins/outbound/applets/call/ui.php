<?php
	$user = OpenVBX::getCurrentUser();
	$tenant_id = $user->values['tenant_id'];
	$ci =& get_instance();
	$ci->load->model('vbx_incoming_numbers');
	$numbers = $ci->vbx_incoming_numbers->get_numbers(false);
	$flows = OpenVBX::getFlows(array('tenant_id' => $tenant_id));
	$selected = AppletInstance::getValue('number');
	$selected_flow = AppletInstance::getValue('flow');
?>
<div class="vbx-applet">
<?php if(count($numbers)): ?>
	<div class="vbx-full-pane">
		<h3>Caller ID</h3>
		<fieldset class="vbx-input-container">
			<select class="medium" name="number">
<?php foreach($numbers as $number): ?>
				<option value="<?php echo $number->phone; ?>"<?php echo $number->phone == $selected ? ' selected="selected" ' : ''; ?>><?php echo $number->name; ?></option>
<?php endforeach; ?>
			</select>
		</fieldset>
		<h3>Flow</h3>
		<fieldset class="vbx-input-container">
			<select class="medium" name="flow">
<?php foreach($flows as $flow): ?>
				<option value="<?php echo $flow->values['id']; ?>"<?php echo $flow->values['id'] == $selected_flow ? ' selected="selected" ' : ''; ?>><?php echo $flow->values['name']; ?></option>
<?php endforeach; ?>
			</select>
		</fieldset>
		<h3>Recipient</h3>
<?php if(AppletInstance::getFlowType() == 'sms'): ?>
		<p>Use %sender% to substitute the sender's number.</p>
<?php endif; ?>
		<fieldset class="vbx-input-container">
			<input type="text" name="recipient" class="medium" value="<?php echo AppletInstance::getValue('recipient'); ?>" />
		</fieldset>
	</div>
	<h2>Next</h2>
	<p>After initiating the call, continue to the next applet</p>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('next'); ?>
	</div>
<?php else: ?>
	<div class="vbx-full-pane">
		<h3>You do not have any phone numbers!</h3>
	</div>
<?php endif; ?>
</div>
