<?php
	$user = OpenVBX::getCurrentUser();
	$tenant_id = $user->values['tenant_id'];
	$ci =& get_instance();
	$queries = explode(';', file_get_contents(dirname(dirname(dirname(__FILE__))).'/db.sql'));
	foreach($queries as $query)
		if(trim($query))
			$ci->db->query($query);
	$polls = $ci->db->query(sprintf('SELECT id, name FROM polls WHERE tenant=%d', $tenant_id))->result();
	$poll = AppletInstance::getValue('poll');
	$poll = $poll ? $poll : count($polls) ? $polls[0]->id : null;
	$options = json_decode($ci->db->query(sprintf('SELECT data FROM polls WHERE tenant=%d AND id=%d', $tenant_id, $poll))->row()->data);
	$option = AppletInstance::getValue('option');
?>
<div class="vbx-applet vbx-polls">
<?php if(count($polls)): ?>
	<div class="vbx-full-pane">
		<h3>Poll</h3>
		<fieldset class="vbx-input-container">
				<select class="medium" name="poll">
<?php foreach($polls as $p): ?>
					<option value="<?php echo $p->id; ?>"<?php echo $poll==$p->id?' selected="selected" ':''; ?>><?php echo $p->name; ?></option>
<?php endforeach; ?>
				</select>
		</fieldset>
		<h3>Selection</h3>
		<fieldset class="vbx-input-container">
			<p>
				<select class="medium" name="option">
<?php if(count($options)) foreach($options as $i => $name): ?>
					<option value="<?php echo $i; ?>"<?php echo $option == $i?' selected="selected"':''; ?>><?php echo $name; ?></option>
<?php endforeach; ?>
				</select>
			</p>
		</fieldset>
	</div>
	<h2>Next</h2>
	<p>After recording the response, continue to the next applet</p>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('next'); ?>
	</div>
<?php else: ?>
	<div class="vbx-full-pane">
		<h3>You need to create a poll first.</h3>
	</div>
<?php endif; ?>
</div>
