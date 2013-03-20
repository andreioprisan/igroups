<div id="dialog-user-edit-or-add-prototype" title="Edit or Add User" class="hide dialog">
	<div class="error-message hide"></div>
	<form class="vbx-form" onsubmit="return false;">
		<input type="hidden" name="id" />
		<fieldset class="vbx-input-container">
			<label class="field-label" for="iFirstName">First Name
				<input type="text" id="iFirstName" class="medium" name="first_name" />
			</label>
			
			<label class="field-label" for="iLastName">Last Name
				<input type="text" id="iLastName" class="medium" name="last_name" />
			</label>
			
			<label class="field-label" for="iEmail">Email
				<input type="text" id="iEmail" class="medium" name="email" />
			</label>

			<div class="single-existing-number">
			<label class="field-label" for="iDeviceNumber">Phone
				<input type="hidden" name="device_id" value="" />
				<input type="text" id="iDeviceNumber" class="medium" name="device_number" />
				<span style="font-style: italic; font-size: 11px;">When a call is routed to this person, this is the number that will be called.</span>
			</label>
			</div>
			
			<div class="multiple-existing-numbers">
				<br />
				<p>This person has multiple devices configured.  They'll<br />need to login to their account, and open My Account<br />to add or remove devices.</p>
			</div>
		</fieldset>

		<br />

		<fieldset class="vbx-input-complex vbx-input-container">
			<label class="field-label-inline" for="iIsAdmin">
				<input type="checkbox" id="iIsAdmin" name="is_admin" value="1" style="display:inline" />
				Administrator
			</label>
		</fieldset>
	</form>
</div>


<div id="dialog-group-edit" title="Add New Group" class="hide dialog">
	<div class="error-message hide"></div>
	<p>Groups of users can be dialed as one entity and can share voicemail messages (i.e. "Sales Team" Group or "Technical Support" Group).</p>
	<form class="vbx-form" onsubmit="return false;">
		<input type="hidden" name="id" />
		<fieldset class="vbx-input-container">
			<label class="field-label" for="iGroup">Group Name
				<input type="text" id="iGroup" class="medium" name="name" />
			</label>
		</fieldset>
	</form>
</div>



