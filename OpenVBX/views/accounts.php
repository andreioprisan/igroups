<div class="vbx-content-main">
	<h2 class="" style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px">Members <small>helps you manage your call users and groups </small></h2>
	<button id="button-add-user" class="btn primary large " style="padding: 2px 15px 2px 15px;float: right;margin-top: 15px;margin-right: 33px;">Add User</button>
	<button id="button-add-group" class="btn primary large " style="padding: 2px 15px 2px 15px;float: right;margin-top: 15px;margin-right: 33px;">Add Group</button>

		<div class="yui-ge accounts-section">
			<div class="yui-u first">	

				<div id="user-container">
				<h2>Users <small>can be added to a group by dragging them to the right</small></h2>

				<ul class="user-list">
				<?php $admin = OpenVBX::getCurrentUser(); ?>
				<?php if(isset($users)): 
					foreach($users as $user): ?>
				<li class="user" rel="<?php echo $user->id ?>">
					<div class="user-utilities">
						<img class="gravatar" src="/assets/i/user.png" height="30" style="padding-left: 3px;" />
						<?php if($user->id != $admin->id): ?>
						<a class="user-edit" href="<?php echo site_url('/account/user/'.$user->id); ?>"><span class="replace">Edit</span></a>
						<a class="user-remove" href="#remove"><span class="replace">Remove</span></a>
						<?php endif; ?>
					</div>
					<div class="user-info">
						<p class="user-name"><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></p>
						<p class="user-email"><?php echo $user->email ?></p>
						<?php if ($user->is_admin): ?>
							<p class="user-administrator">Administrator</p>
						<?php endif; ?>
					</div>
				</li>
				<?php 
					endforeach; 
				endif; ?>
				<li class="user" rel="prototype" style="display:none;">
					<div class="user-utilities">
						<img class="gravatar" src="<?php echo $default_avatar; ?>" width="30" height="30" />
						<a class="user-edit" href="#edit"><span class="replace">Edit</span></a>
						<a class="user-remove" href="#remove"><span class="replace">Remove</span></a>
					</div>
					<div class="user-info">
						<p class="user-name">(prototype)</p>
						<p class="user-email"></p>
					</div>
				</li>
				</ul>
				</div><!-- #user-container -->

			</div><!-- .yui-u .first -->
			
			<div class="yui-u">

				<div id="group-container">
				<h2>Groups</h2>
<!--				<p>Click to view the user list and drag users to reorder them</p>
-->
				<ul class="group-list" style="margin: 0 0 9px 0px;"> 
				<?php if(isset($groups)) foreach($groups as $group_id => $group): ?>
					<li class="group" rel="<?php echo $group_id ?>">
							<img class="group-counter-loader hide" src="<?php echo asset_url('assets/i/ajax-loader-circle.gif'); ?>" alt="loading" />
							<span class="group-counter"><?php echo count($group->users) ?></span>

							<div class="group-utilities">
								<a class="group-edit" href="#edit">Edit Group</a>
								<a class="group-remove" href="#remove">Remove Group</a>
							</div>

							<div class="group-info">
								<p class="group-name"><?php echo $group->name; ?></p>
							</div>

							<ul class="members">
							<?php foreach($group->users as $user): ?>
								<li rel="<?php echo $user->user_id; ?>">
									<?php if(!empty($user->first_name)) : ?>
									<span><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></span>
									<?php else: ?>
									<span><?php echo $user->email; ?></span>
									<?php endif;?>
									<a class="remove">Remove</a>
								</li>
							<?php endforeach; ?>
							</ul>

					</li><?php endforeach; ?>

					<li class="group" rel="prototype" style="display:none;">
						<span class="group-counter">0</span>
						<div class="group-utilities">
							<a class="group-edit" href="#">Edit Group</a>
							<a class="group-remove" href="#">Remove Group</a>
						</div>

						<div class="group-info">
							<p class="group-name">(Prototype)</p>
						</div>
						<ul class="members"></ul>
					</li>
				</ul>
				</div><!-- #group-container -->

			</div><!-- .yui-u -->

		</div><!-- .yui-ge 3/4, 1/4 -->

</div><!-- .vbx-content-main -->

<div id="accounts-dialogs" style="display: none;">
	<div id="dialog-invite-user" title="Invite User" class="hide dialog">
		<div class="error-message hide"></div>
		<form class="vbx-form" onsubmit="return false;">
			<fieldset class="vbx-input-container">
			<label class="field-label">Email
				<input type="text" class="medium" name="email" value="" />
			</label>
			</fieldset>
		</form>
	</div>

	<div id="dialog-google-app-sync" title="Use Google Apps for Domains" class="hide dialog">
		<div class="error-message hide"></div>
		<form class="vbx-form" onsubmit="return false;">
			<p>Enter your Email and Password for your Google Apps Domain</p>
			<fieldset class="vbx-input-container">
			<label class="field-label">Email
				<input type="text" class="medium" name="email" value="" />
			</label>
			<label class="field-label">Password
				<input type="password" class="medium" name="password" value="" />
			</label>
			</fieldset>
		</form>
	</div>

	<?php include("user_group_dialogs.php"); ?>

	<div id="dialog-delete" title="Delete" class="hide dialog">
		<div class="error-message hide"></div>
		<div id="dConfirmMsg">
			<p>Are you sure you want to delete?</p>
		</div>
	</div>
</div>