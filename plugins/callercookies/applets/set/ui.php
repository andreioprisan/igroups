<?php
$defaultNumberOfChoices = 1;
$names = (array) AppletInstance::getValue('names[]', array('1' => '') );
$values = (array) AppletInstance::getValue('values[]');
?>
<div class="vbx-applet set-cookie">
		<h2>Set Cookie</h2>
		<table class="vbx-menu-grid options-table">
			<thead>
				<tr>
					<td>Name</td>
					<td>&nbsp;</td>
					<td>Value</td>
					<td>Add &amp; Remove</td>
				</tr>
			</thead>
			<tfoot>
				<tr class="hide">
					<td>
						<fieldset class="vbx-input-container">
							<input class="keypress small" type="text" name="new-names[]" value="" autocomplete="off" />
						</fieldset>
					</td>
					<td>&nbsp;</td>
					<td>
						<fieldset class="vbx-input-container">
							<input class="keypress small" type="text" name="new-values[]" value="" autocomplete="off" />
						</fieldset>
					</td>
					<td>
						<a href="" class="add action"><span class="replace">Add</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($names as $id => $name): ?>
				<tr>
					<td>
						<fieldset class="vbx-input-container">
							<input class="keypress small" type="text" name="names[]" value="<?php echo $name ?>" autocomplete="off" />
						</fieldset>
					</td>
					<td></td>
					<td>
						<fieldset class="vbx-input-container">
							<input class="keypress small" type="text" name="values[]" value="<?php echo $values[$id] ?>" autocomplete="off" />
						</fieldset>
					</td>
					<td>
						<a href="" class="add action"><span class="replace">Add</span></a> <a href="" class="remove action"><span class="replace">Remove</span></a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table><!-- .vbx-menu-grid -->
		<p>After the cookies are set, continue to the next applet</p>
		<?php echo AppletUI::dropZone('next'); ?>
    	<br />
</div><!-- .vbx-applet -->