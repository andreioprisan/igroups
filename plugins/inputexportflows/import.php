<?php
	if(!empty($_POST))
		$error = true;
	if(!empty($_POST['name'])) {
		$name = htmlentities($_POST['name']);
		if(($file = $_FILES['file']['tmp_name']) && is_uploaded_file($file))
			$import = file_get_contents($file);
		else
			$import = NULL;
		$parts = explode(':', $import);
		if(count($parts) > 2) {
			$data = base64_decode($parts[1]);
			$sms_data = base64_decode($parts[2]);
			if(trim($parts[0]) == md5($data . $sms_data)) {
				$user = OpenVBX::getCurrentUser();
				$user_id = $user->values['id'];
				$tenant_id = $user->values['tenant_id'];
				$ci =& get_instance();
				$ci->db->insert('flows', array(
					'name' => $name,
					'user_id' => $user_id,
					'data' => $data,
					'sms_data' => $sms_data,
					'tenant_id' => $tenant_id
				));
				$error = false;
			}
		}
	}
?>
<style>
	.vbx-import-flow form {
		margin-top: 20px;
		display:inline;
	}
	.vbx-import-flow p {
		margin: 0px 0;
		padding: 0 0px;
		display:inline;
	}
</style>

<div class="vbx-content-main" style="padding-left:8px; padding-top:20px">
	<h3 style="display:inline;">Import Flow</h3>
	<form method="post" action="" enctype="multipart/form-data"  style="display:inline;"><input placeholder="Flow Name" type="text" name="name" class="medium" style="width:180px" /><input style="width:200px" type="file" name="file" class="medium" /><button type="submit" class="btn primary">Import iGroups Flow File (.igf)</button>
	</form>
	<br />
	<p>Soon, you will be able to import sample flows from our gallery, please stay tuned :)</p>
	<?php if($error): ?>
	<p>We could not import your iGroups Flow File. Please try again or contact support at support@igrou.ps for assistance :)</p>
	<?php endif; ?>
</div>
