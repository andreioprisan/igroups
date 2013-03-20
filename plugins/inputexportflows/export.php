<?php
	$user = OpenVBX::getCurrentUser();
	$tenant_id = $user->values['tenant_id'];
	if(isset($_POST['id'])) {
		$flows = OpenVBX::getFlows(array('id' => $_POST['id'], 'tenant_id' => $tenant_id));
		$data = $flows[0]->values['data'];
		$sms_data = $flows[0]->values['sms_data'];
		$export = md5($data . $sms_data) . ':' . base64_encode($data) . ':' . base64_encode($sms_data);

		header('Content-type: text/plain');
		header('Content-Disposition: attachment; filename=' . preg_replace('/\W/', '', $flows[0]->values['name']) . '.igf');
		echo $export;
		
		die;
	}
	$flows = OpenVBX::getFlows(array('tenant_id' => $tenant_id));
?>
<style>
	.vbx-export-flow form {
		margin-top: 20px;
		display:inline;
	}
	.vbx-export-flow p {
		margin: 10px 0;
		padding: 0 20px;
		display:inline;
	}
	.vbx-export-flow h3 {
		font-size: 14px;
		padding: 0 20px;
		margin-top: 20px;
		display:inline;
	}
</style>
<div class="vbx-content-main" style="padding-left:8px; padding-top:20px; padding-bottom:20px">
	<h3 style="display:inline;">Export Flow</h3>
	<?php if(count($flows)) { ?>
	<form method="post" action="" style="display:inline;">
		<label class="field-label"  style="display:inline;">
			<select name="id" class="medium">
			<?php foreach($flows as $flow): ?>
				<option style="display:inline;" value="<?php echo $flow->values['id']; ?>"<?php echo isset($_POST['id']) && $_POST['id'] == $flow->values['id'] ? ' selected="selected"' : ''; ?> style="display:inline;"><?php echo $flow->values['name']; ?></option>
			<?php endforeach; ?>
			</select>
			<button type="submit" class="btn primary"><span>Export to iGroups Flow File (.igf)</span></button>
		</label>
	</form>
	<?php } else { ?>
	<h3>You do not have any flows.</h3>
	<?php } ?>
</div>
