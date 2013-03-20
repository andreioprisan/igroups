<?php
	$ci =& get_instance();
	$ci->load->model('vbx_incoming_numbers');
	$numbers = $ci->vbx_incoming_numbers->get_numbers(false);
	$selected = AppletInstance::getValue('number');
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
		<h3>Recipient</h3>
		<fieldset class="vbx-input-container">
			<input type="text" name="recipient" class="medium" value="<?php echo AppletInstance::getValue('recipient'); ?>" />
		</fieldset>
		<h3>Message</h3>
<?php if(AppletInstance::getFlowType() == 'voice'): ?>
		<p>Use %caller% to substitute the caller's number or %number% for the number called.</p>
<?php else: ?>
		<p>Use %sender% to substitute the sender's number, %number% for the number texted or %body% for the message body.</p>
<?php endif; ?>
		<fieldset class="vbx-input-container">
			<textarea name="sms" class="medium"><?php echo AppletInstance::getValue('sms'); ?></textarea>
		</fieldset>
	</div>
	<h2>Next</h2>
	<p>After sending the message, continue to the next applet</p>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('next'); ?>
	</div>
<?php else: ?>
	<div class="vbx-full-pane">
		<h3>You do not have any phone numbers!</h3>
	</div>
<?php endif; ?>
</div>
