<?php 
$gotoflow = AppletInstance::getValue('gotoflow');
$redirect_type_selector = AppletInstance::getValue('redirect-type-selector', 'flow');

?>
<div class="vbx-applet subflow-applet">
		<h2>Transfer</h2>
		<p>Continue this flow by starting another flow or redirecting to an iGroups Flow URL.</p>
		<?php 
		
		/*
		foreach(OpenVBX::GetFlows() as $flow)
		{
			
			echo $flow->values['name'];
		}
		*/
		?>
		<pre><?php // print_r(OpenVBX::GetFlows()); ?></pre>


	<div class="radio-table">
		<table>
			<tr class="radio-table-row first <?php echo ($redirect_type_selector === 'flow') ? 'on' : 'off' ?>">
				<td class="radio-cell">
					<input type="radio" name="redirect-type-selector" value="flow" <?php echo ($redirect_type_selector === 'flow') ? 'checked="checked"' : '' ?> />
				</td>
				<td class="content-cell">
					<div style="float: left;"><h4>Redirect to a call flow</h4></div>
					<div style="float: right;">

					<select name="gotoflow" class="medium">
						<?php foreach(OpenVBX::GetFlows() as $flow): ?>
						<option value="<?php echo $flow->values['id']; ?>" <?php echo ($gotoflow == $flow->values['id'])? 'selected="selected"' : '' ?>><?php echo $flow->values['name'];?></option>
						<?php endforeach; ?>
					</select>


					</div>
				</td>
			</tr>
			<tr class="radio-table-row last <?php echo ($redirect_type_selector === 'url') ? 'on' : 'off' ?>">
				<td class="radio-cell">
					<input type="radio" name="redirect-type-selector" value="url" <?php echo ($redirect_type_selector === 'url') ? 'checked="checked"' : '' ?> />
				</td>
				<td class="content-cell">
					<div style="float: left;"><h4>Redirect to a URL</h4></div>
					<div style="float: right;">
						<div class="vbx-input-container input">
							<input type="text" class="medium" name="gotourl" value="<?php echo AppletInstance::getValue('gotourl') ?>"/>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<script>
		$(".subflow-applet input[type=radio]").live('click', function(event) {
			var tr = $(this).closest('tr');
			
			tr.closest('table').find('tr').each(function (index, element) {
				// Set the others to off
				$(element).removeClass('on').addClass('off');
			});
			
			tr.addClass('on').removeClass('off');
		});
			
		</script>
	</div>

		<br />


</div><!-- .vbx-applet -->
