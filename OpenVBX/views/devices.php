<div class="vbx-content-main">
	<div class="">
		<h2 class="" style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px">Devices <small>lets you manage your external numbers, like your cell phone or landline</small></h2>
		<button class="btn primary large add-device" style="padding: 2px 15px 2px 15px;float: right;margin-top: 15px;margin-right: 33px;">Add a Device</button>
	</div>


		<div class="devices-blank <?php if(!empty($devices)): ?>hide<?php endif; ?>">
			<p style="padding-left: 10px;">No devices set up yet.</p>
		</div>


	<div class="vbx-content-container">

		<div class="vbx-content-section">
		<form class="vbx-form" action="">

		<div class="device-container">
		<ol class="device-list <?php if(empty($devices)): ?>hide<?php endif; ?>">
			<?php foreach($devices as $device): 
				if ($device->id == 0) { continue; } ?>
			<li class="phone device enabled ui-state-default" rel="<?php echo $device->id ?>">
				<fieldset class="vbx-input-complex">

					<label class="field-label-inline left">
						<div class="device-type phone-type"><span class="replace">Phone</span></div>
						<p class="device-name"><?php echo htmlentities($device->name); ?></p>
					</label>

					<p class="device-value"><?php echo format_phone($device->value); ?></p>

					<label class="field-label-inline left">
						<input type="checkbox" class="enable-sms checkbox" <?php echo $device->sms == 1? 'checked="checked"'  :'' ?> />
						SMS Notifications
					</label>

					<a href="" class="action trash" title="Delete"><span class="replace">Delete</span></a>

					<div class="device-status">
						<a href="" class="<?php echo ($device->is_active == 1)? 'enabled' : 'disabled' ?> on">ON</a>
						<a href="" class="<?php echo ($device->is_active == 0)? 'enabled' : 'disabled' ?> off">OFF</a>
						<input type="checkbox" class="enable-device checkbox" value="1" <?php echo ($device->is_active == 1)? 'checked="checked"' : '' ?> />
					</div>

				</fieldset>
			</li>
			<?php endforeach; ?>

			<li class="prototype hide">
				<fieldset class="vbx-input-complex">
					<label class="field-label-inline left">
						<div class="device-type phone-type"><span class="replace">Phone</span></div>
						<p class="device-name"></p>
					</label>

					<p class="device-value"></p>

					<label class="field-label-inline left">
						<input type="checkbox" class="enable-sms checkbox" checked="checked"/>
						SMS notifications
					</label>

					<a href="" class="btn danger small trash" title="Delete" style="right: 10px;"><font color="white">Delete</font></a>
					<!-- <a href="" class="action edit" title="Edit"><span class="replace">Edit</span></a> -->

					<div class="device-status">
						<a href="" class="enabled on">ON</a>
						<a href="" class="disabled off">OFF</a>
						<input type="checkbox" class="enable-device checkbox" value="1" checked="checked" />
					</div>

				</fieldset>
			</li>
		</ol>


		</div><!-- .device-container -->
		</form>


		</div><!-- .vbx-content-section -->


	</div><!-- .vbx-content-container -->


</div><!-- .vbx-content-main -->



<div id="dialog-number" style="display: none;" class="new number dialog" title="Add Devices">
		<div class="hide error-message"></div>
		<div class="vbx-form">
			<fieldset class="vbx-input-container">
				<label class="field-label">Device Name
					<input type="text" class="medium" name="number[name]" value="" />
				</label>
			</fieldset>

			<fieldset class="vbx-input-container">
				<label class="field-label">Phone Number
					<input type="text" class="medium" name="number[value]" value="" />
				</label>
			</fieldset>
		</div>
</div>


