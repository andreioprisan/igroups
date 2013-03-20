<div class="vbx-content-container">
		<div id="login" class="login-reset">
			<form action="<?php echo site_url('auth/reset'); ?>" method="post" class="vbx-form">

			<input type="hidden" name="login" value="1" />
			<h2>Reset password <small>Give us your E-Mail Address and we'll send you a new password</small></h2><br>
			<fieldset class="vbx-input-container">
					<label class="field-label">E-Mail Address
					<input type="text" class="medium" name="email" value="" />
					</label>
			</fieldset>
			
			<button type="submit" class="submit-button btn primary ">&nbsp; Submit</button>
			<a class=" btn danger remember-password" href="/auth/login" style="float:left; position:relative; top:-8px; left:60px"><font color="white">Remember your password?</font></a>

			</form>
		</div><!-- #login -->
</div><!-- .vbx-content-container -->
