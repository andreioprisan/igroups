<?php
$defaultNumberOfChoices = 4;
$keys = AppletInstance::getValue('keys[]', array('1','2','3','4') );
$choices = AppletInstance::getValue('choices[]');
?>

<div class="vbx-applet callerid-applet">

		<h2>Caller ID Router</h2>
		<p>Type phone numbers without spaces or punctuation.  For example, <code>8005551234</code> instead of <code>(800) 555-1234</code>.</p>
		<table class="vbx-callerid-grid options-table">
			<thead>
				<tr>
					<td>Caller ID</td>
					<td>&nbsp;</td>
					<td>Applet</td>
					<td>Add &amp; Remove</td>
				</tr>
			</thead>
			<tfoot>
				<tr class="hide">
					<td>
						<fieldset class="vbx-input-container">
							<input class="keypress" type="text" name="new-keys[]" value="" autocomplete="off" />
						</fieldset>
					</td>
					<td>then</td>
					<td>
						<?php echo AppletUI::dropZone('new-choices[]', 'Drop item here'); ?>
					</td>
					<td>
						<a href="" class="add action"><span class="replace">Add</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($keys as $i=>$key): ?>
				<tr>
					<td>
						<fieldset class="vbx-input-container">
							<input class="keypress" type="text" name="keys[]" value="<?php echo $key ?>" autocomplete="off" />
						</fieldset>
					</td>
					<td>then</td>
					<td>
						<?php echo AppletUI::dropZone('choices['.($i).']', 'Drop item here'); ?>
					</td>
					<td>
						<a href="" class="add action"><span class="replace">Add</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table><!-- .vbx-callerid-grid -->

		<h3>Oops!</h3>
		<p>When the caller ID is not in the above list</p>
		<?php echo AppletUI::dropZone('invalid'); ?>
    	<br />
</div><!-- .vbx-applet -->
