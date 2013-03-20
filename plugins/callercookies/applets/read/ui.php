<div class="vbx-applet">
<?php if(AppletInstance::getFlowType() == 'voice'): ?>
	<h3>Read the following text</h3>
<?php else: ?>
	<h3>Send the following text</h3>
<?php endif; ?>
	<p>Use %name% to substitute the cookie's value, where name is the name of the cookie.</p>
	<fieldset class="vbx-input-container">
		<textarea name="text" class="medium"><?php echo AppletInstance::getValue('text'); ?></textarea>
	</fieldset>
	<h2>Next</h2>
<?php if(AppletInstance::getFlowType() == 'voice'): ?>
	<p>After the value is read, continue to the next applet</p>
<?php else: ?>
	<p>After the response is sent, continue to the next applet</p>
<?php endif; ?>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('next'); ?>
	</div><!-- .vbx-full-pane -->
</div><!-- .vbx-applet -->
