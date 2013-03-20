<div class="vbx-content-main">
	<h2 class="" style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px">Flows <small>Manage the way your phone numbers respond via voice and SMS</small></h2>
	<?php if(!empty($items)): ?>
	<button class="btn primary large add number addnewflow" style="padding: 2px 15px 2px 15px;float: right;margin-top: 15px;margin-right: 33px;">New Flow</button>
	<?php endif; ?>

		<?php if(!empty($items)): ?>

		<div class="vbx-table-section">
		<table id="flows-table" class="vbx-items-grid">
			<thead>
				<tr class="items-head">
					<th class="flow-name">Name</th>
					<th class="flow-numbers">Phone Numbers</th>
					<th class="flow-voice">Call Flow</th>
					<th class="flow-sms">SMS Flow</th>
					<th class="flow-delete" style="width:70px">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($items as $item): ?>
				<tr id="flow-<?php echo $item['id']?>" class="items-row <?php if(in_array($item['id'], $highlighted_flows)): ?>highlight-row<?php endif; ?>">
					<td>
						<span class="flow-name-display"><?php echo $item['name']; ?></span>
						<span class="flow-name-edit" style="display: none;">
							<input type="text" name="flow_name" value="<?php echo $item['name'] ?>" data-orig-value="<?php echo $item['name']; ?>" style="width: 170px"/>
							<button name="save" value="Save" data-action="/flows/edit/<?php echo $item['id']; ?>" class="submit-button btn success">&nbsp;&nbsp;Save</button> <a href="#cancel" class="flow-name-edit-cancel btn">Cancel</a>
						</span>
					</td>
					<?php if(empty($item['numbers'])): ?>
					<td>None</td>
					<?php else: ?>
					<td><?php echo implode(', ', $item['numbers']); ?></td>
					<?php endif; ?>
					<td><a class="btn" href="<?php echo site_url("flows/edit/{$item['id']}"); ?>#flowline/start"><?php echo is_null($item['voice_data'])? 'Create' : 'Edit' ?> Call Flow</a></td>
					<td><a class="btn" href="<?php echo site_url("flows/sms/{$item['id']}"); ?>#flowline/start"><?php echo is_null($item['sms_data'])? 'Create' : 'Edit' ?> SMS Flow</a></td>
					<td class="flow-delete"><a href="flows/edit/<?php echo $item['id'];?>" class="btn danger trash action" title="Delete" style="height: 14px; width:35px;"><font color="white">Delete</font></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table><!-- .vbx-items-grid -->
		
		<iframe name="openvbx-iframe" id="openvbx-iframe" src="/p/flowtest" width="100%" height="65px" frameborder="no" scrolling="no">
			&lt;p&gt;Your browser doesn't support iFrames.&lt;/p&gt;
		</iframe>

		<iframe name="openvbx-iframe" id="openvbx-iframe" src="/p/import" width="100%" height="76px" frameborder="no" scrolling="no">
			&lt;p&gt;Your browser doesn't support iFrames.&lt;/p&gt;
		</iframe>
<br />
		<iframe name="openvbx-iframe" id="openvbx-iframe" src="/p/export" width="100%" height="58px" frameborder="no" scrolling="no">
			&lt;p&gt;Your browser doesn't support iFrames.&lt;/p&gt;
		</iframe>

		</div><!-- .vbx-table-section -->

		<?php else: ?>

		<div class="vbx-content-container" style="padding-left: 8px;">
			<h3 style="display:inline;">Create a New Flow with the Flow Builder</h3>
			<button class="btn primary large add number addnewflow" style="padding: 2px 15px 2px 15px;float: right;margin-top: 0px;margin-right: 33px;">New Flow</button>
			<p style="font-size:16px;">Flows allow you to control what happens on a call or SMS communication, such as forwarding the call to other people or groups, taking voicemails, playing audio or text to the caller, create conference calls, responding based on SMS keywords, and others.</p>
		</div>
		<div class="vbx-content-section"></div>
		</div><!-- .vbx-content-container -->

		<?php endif; ?>

				




</div><!-- .vbx-content-main -->

<div id="dialog-templates" style="display: none">
	<div id="dAddFlow" title="Add New Flow" class="dialog">
		<form action="<?php echo site_url('flows'); ?>" method="post" class="vbx-form">
			<fieldset class="vbx-input-container">
			<label class="field-label">Flow Name
			<input type="text" name="name" class="medium" />
			</label>
			</fieldset>
		</form>
	</div>

	<div id="dDeleteFlow" title="Delete Flow?" class="dialog">
		<p>Are you sure you wish to delete this flow?</p>
	</div>

	<div id="dCopyFlow" title="Copy Flow" class="dialog">
		<form action="#" method="post" class="vbx-form">
			<fieldset class="vbx-input-container">
			<label class="field-label">Please enter a name for the new flow
			<input type="text" name="name" class="medium" />
			</label>
			</fieldset>
		</form>
	</div>
</div>