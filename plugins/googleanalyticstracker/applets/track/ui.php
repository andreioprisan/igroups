<div class="vbx-applet">
	<div class="vbx-full-pane">
		<h3>Google Analytics account</h3>
		<fieldset class="vbx-input-container">
			<input type="text" name="account" class="medium" value="<?php echo AppletInstance::getValue('account','UA-XXXXX-X'); ?>" />
		</fieldset>
		<h3>URL to track</h3>
		<p>Use %caller% to substitute the caller's number or %number% for the number called.</p>
		<fieldset class="vbx-input-container">
			<input type="text" name="url" class="medium" value="<?php echo AppletInstance::getValue('url','/some-page'); ?>" />
		</fieldset>
		<h3>Page title to track</h3>
		<p>Use %caller% to substitute the caller's number or %number% for the number called.</p>
		<fieldset class="vbx-input-container">
			<input type="text" name="title" class="medium" value="<?php echo AppletInstance::getValue('title','Applet name'); ?>" />
		</fieldset>
	</div>

	<h2>Next</h2>
	<p>After this applet is tracked, continue to the next applet</p>
	<div class="vbx-full-pane">
		<?php echo AppletUI::DropZone('next'); ?>
	</div><!-- .vbx-full-pane -->

</div><!-- .vbx-applet -->
