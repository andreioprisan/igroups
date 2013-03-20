<?php
	$user = OpenVBX::getCurrentUser();
	$tenant_id = $user->values['tenant_id'];
	$ci =& get_instance();
	$queries = explode(';', file_get_contents(dirname(__FILE__) . '/db.sql'));
	foreach($queries as $query)
		if(trim($query))
			$ci->db->query($query);
	if(!empty($_POST['remove'])) {
		$remove = intval($_POST['remove']);
		$ci->db->delete('polls', array('id' => $remove, 'tenant' => $tenant_id));
		if($ci->db->affected_rows())
			$ci->db->delete('polls_responses', array('poll' => $remove));
		die;
	}
	if(!empty($_REQUEST['poll'])) {
		echo $ci->db->query(sprintf('SELECT data FROM polls WHERE tenant = %d AND id = %d', $tenant_id, intval($_REQUEST['poll'])))->row()->data;
		die;
	}
	if(!empty($_POST['name']) && 1 < count($_POST['option'])) {
		$name = htmlentities($_POST['name']);
		$options = $_POST['option'];
		foreach($options as &$option)
			$option = htmlentities($option);
		$ci->db->insert('polls', array(
			'tenant' => $tenant_id,
			'name' => $name,
			'data' => json_encode($options)
		));
	}
	$polls = $ci->db->query(sprintf('SELECT id, name, data, (SELECT COUNT(id) FROM polls_responses WHERE polls_responses.poll = polls.id) AS responses FROM polls WHERE tenant = %d', $tenant_id))->result();
	OpenVBX::addJS('polls.js');
?>
<style>
	.vbx-polls h3 {
		font-size: 16px;
		font-weight: bold;
		margin-top: 0;
	}
	.vbx-polls .poll,
	.vbx-polls div.option {
		clear: both;	
		width: 100%;
		overflow: hidden;
		margin: 0 auto;
		padding: 0px 0;
		border-bottom: 1px solid #eee;
		list-style: disc;
	}
	.vbx-polls div.option {
		display: none;
		background: #ccc;
	}
	.vbx-polls .poll span {
		display: inline-block;
		width: 25%;
		text-align: center;
		float: left;
		vertical-align: middle;
		line-height: 24px;
	}
	.vbx-polls .option span {
		display: inline-block;
		width: 25%;
		text-align: center;
		float: left;
		vertical-align: middle;
		line-height: 24px;
	}
	.vbx-polls .poll a {
		text-decoration: none;
		color: #111;
	}
	.vbx-polls form {
		display: none;
		padding: 20px 0px 0px 8px;
	}
	.vbx-polls a.delete {
		display: inline-block;
		height: 24px;
		width: 24px;
		text-indent: -999em;
	}
</style>
<div class="vbx-content-main">
	<h2 class="" style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px">Poll <small>via phone or SMS</small></h2>
	<button id="button-add-poll" class="btn primary large add number addnewflow addcallorsmsschedule" style="padding: 2px 15px 2px 15px;float: right;margin-top: 15px;margin-right: 33px;">Add Poll</button>
	
    <div class="vbx-table-section vbx-polls">
		<form method="post" action="">
			<h2>Add Poll</h2>
			<fieldset class="vbx-input-container">
				<label class="field-label">
					<input type="text" class="medium" name="name" placeholder="Poll Name"/>
				</label>
				<label class="field-label option">
					<input type="text" class="medium" name="option[]" placeholder="Option"/>
				</label>
				<p>
					<button type="submit" class="inline-button submit-button btn success">&nbsp; Add Option</span></button>
					<button type="submit" class="inline-button submit-button btn primary">&nbsp; Save</span></button>
					<button id="button-add-poll" class="btn danger"> Cancel</span></button>
				</p>
			</fieldset>
		</form>
<?php if(count($polls)) { ?>
	<table class="phone-numbers-table vbx-items-grid poll" data-type="incoming">
		<thead>
			<tr class="items-head">
				<th class="incoming-number-phone">Name</th>
				<th class="incoming-number-phone">Options</span>
				<th class="incoming-number-phone">Responses</th>
				<th class="incoming-number-phone" style="width: 70px;">&nbsp;</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($polls as $poll):
			$options = json_decode($poll->data);
			$responses = $ci->db->query(sprintf('SELECT COUNT(id) AS num FROM polls_responses WHERE polls_responses.poll = %d GROUP BY response ORDER BY response', $poll->id))->result(); ?>
			<tr class="items-row poll" id="poll_<?php echo $poll->id; ?>">
				<td class="incoming-number-phone"><?php echo $poll->name; ?></td>
				<td class="incoming-number-phone"><a href="" class="options btn"><?php echo count($options); ?></a></td>
				<td class="incoming-number-phone">&nbsp;<a href="" class="options btn"><?php echo $poll->responses; ?></a></td>
				<td class="incoming-number-delete"><a id="button-delete-poll" href="#" class="btn danger" style="height: 14px; width:35px;"><font color="white">Delete</font></a></td>
			</tr>
			<?php foreach($options as $i => $option): ?>
			<tr class="option poll_<?php echo $poll->id; ?>">
				<td class="incoming-number-phone">&nbsp;</td>
				<td class="incoming-number-phone"><?php echo $option; ?></td>
				<td class="incoming-number-phone"><a href="" class="btn"><?php echo $ci->db->query(sprintf('SELECT COUNT(id) AS num FROM polls_responses WHERE poll = %d AND response = %d', $poll->id, $i))->row()->num; ?></a></td>
				<td class="incoming-number-phone">&nbsp;</td>
			</tr>
			<?php endforeach; ?>

		<?php endforeach; ?>
		</tbody>
	</table>
<?php } else {  ?>
	<p style="padding-left: 8px;">You have no polls that can be used with the flow builder at this time. Add one above!</p><br /><br />
<?php } ?>
    </div>
</div>
