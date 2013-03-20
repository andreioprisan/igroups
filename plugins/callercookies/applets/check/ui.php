<div class="vbx-applet">
	<h2>Check Cookie</h2>
	<p>Tip: Enter "null" or "not null" for the value to check if it's empty or contains any value.</p>
	<table class="vbx-menu-grid options-table">
		<thead>
			<tr>
				<td>Name</td>
				<td>&nbsp;</td>
				<td>Value</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<fieldset class="vbx-input-container">
						<input class="keypress small" type="text" name="name" value="<?php echo AppletInstance::getValue('name'); ?>" autocomplete="off" />
					</fieldset>
				</td>
				<td>&nbsp;</td>
				<td>
					<fieldset class="vbx-input-container">
						<input class="keypress small" type="text" name="value" value="<?php echo AppletInstance::getValue('value'); ?>" autocomplete="off" />
					</fieldset>
				</td>
				<td>
					<?php echo AppletUI::dropZone('pass', 'Drop applet here'); ?>
				</td>
			</tr>
		</tbody>
	</table><!-- .vbx-menu-grid -->
	<h3>If cookie does not match value:</h3>
	<?php echo AppletUI::dropZone('fail'); ?>
	<br />
</div><!-- .vbx-applet -->