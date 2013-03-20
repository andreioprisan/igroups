<div class="vbx-content-container">

	<div id="login">
		We're in closed alpha while we work out the kinks. Email <a href="mailto:contact@igrou.ps">contact@igrou.ps</a> for an invite.<br><br>
		
		<h2>Login <small>with your beta username and password</small></h2><br>
		
		<form action="<?php echo site_url('auth/login'); ?>?redirect=<?php echo urlencode($redirect) ?>" method="post" class="vbx-login-form vbx-form">

				<div class="vbx-input-container">		
				<label for="iEmail" class="field-label">E-Mail Address
					<input type="text" id="iEmail" name="email" value="" class="medium" />
				</label>
				
				<label for="iPass" class="field-label">Password
					<input type="password" id="iPass" name="pw" class="medium" />
				</label>
				</div>

				<input type="hidden" name="login" value="1" />
				<button type="submit" class="submit-button btn primary ">&nbsp; Log In</button>
				<a class=" btn danger forgot-password" href="../auth/reset" style="float:left; position:relative; top:-8px; left:120px"><font color="white">Forgot password?</font></a>
		</form>
		
		
	</div><!-- #login .vbx-content-section -->

</div><!-- .vbx-content-container -->
