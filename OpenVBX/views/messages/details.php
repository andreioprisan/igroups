<div class="vbx-content-main">

	<form id="message-details" class="vbx-form horizontal-form" action="<?php echo site_url("messages/details/$id") ?>" method="post">
		<a href="<?php echo site_url("messages/inbox/$folder_id") ?>" class="btn large delete-button link-button" style="float: right;margin-top: 15px;margin-right: 33px;">Back to Inbox</a>

		<h2 class="" style="display:inline; padding: 20px 0px 10px 8px; line-height: 60px">Details <small>see all message details, save notes and update call status</small></h2>
		<a id="delete-<?php echo $id?>" class="btn primary large delete-button link-button" style="float: right;margin-top: 15px;margin-right: 33px;">Archive</a>
		<a id="save-details" class="btn large success delete-button link-button" style="float: right;margin-top: 15px;margin-right: 33px;">Update</a>
		
		<br/>
		<br/>
		<br/>
		<div style="padding-left:20px">
			<fieldset class="control-group">
				<label class="control-label" for="optionsCheckbox">Received At</label>
				<div class="controls">
					<label class="checkbox date-created unformatted-relative-timestamp"><?php echo strtotime($received_time) ?></label>
				</div>
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" for="optionsCheckbox">From</label>
				<div class="controls">
					<label class="checkbox"><?= $caller ?></label>
					<a href="" class="quick-call-button"><span class="replace">Call</span></a>
					<div id="quick-call-popup-<?php echo $id ?>" class="quick-call-popup hide">
						<a href="" class="close action toggler"><span class="replace">close</span></a>	
						<p class="call-from-number"><?php echo $caller ?></p>
						<ul class="caller-id-phone">
							<li><a href="<?php echo site_url("messages/details/{$id}/callback") ?>" class="call">Call<span class="to hide"><?php echo $caller ?></span> <span class="callerid hide"><?php echo $called ?></span><span class="from hide"><?php echo isset($user_numbers[0])? $user_numbers[0]->value : '' ?></span></a></li>
						</ul>
					</div>
					
				</div>
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" for="optionsCheckbox">To</label>
				<div class="controls">
					<label class="checkbox"><?= $called ?></label>
				</div>
			</fieldset>
			<?php if($type == 'voice'): ?>
			<fieldset class="control-group">
				<label class="control-label" for="optionsCheckbox">Status</label>
				<div class="controls">
					<label class="checkbox">
						<fieldset class="">
						<select id="ticket-status" class="small" name="ticket_status">
							<?php foreach(array('pending', 'open', 'closed') as $status): $selected = ($status == $ticket_status)? 'selected="selected"' : '' ?>
							<option value="<?php echo $status ?>" <?php echo $selected ?>><?php echo $status ?></option>
							<?php endforeach; ?>
						</select>
						</fieldset>
					</label>
				</div>
			</fieldset>
			<?php if($owner_type == 'group'): ?>
			<fieldset class="control-group">
				<label class="control-label" for="optionsCheckbox">Assign to:</label>
				<div class="controls">
					<label class="checkbox">
						<fieldset class="">
						<select id="assign-to" class="medium" name="assigned">
							<option>Select a user</option>
							<?php foreach($active_users as $user): ?>
							<option value="<?php echo $user['id'] ?>" <?php echo $user['id'] == $assigned? 'selected="selected"' : '' ?>>
								<?php echo format_name($user) ?>
							</option>
							<?php endforeach; ?>
						</select>
						</fieldset>
					</label>
				</div>
			</fieldset>
			<?php endif; ?>
			<?php endif; ?>
			<?php if($type == 'voice'): ?>
			<fieldset class="control-group">
				<label class="control-label" for="optionsCheckbox">Listen</label>
				<div class="controls">
					<label class="checkbox">
						<div class="message-details-playback message-row" style=" border-top: 0px;">
							<table>
								<tbody>
									<tr>
										<td>
											<a id="play-<?php echo $id ?>" href="<?php echo site_url("messages/details/$id") ?>" class="playback-button play quick-play">
												<span class="replace">Play</span>
												<span class="call-duration"><?php echo $recording_length ?></span>
											</a>
										</td>
										<td id="player-<?php echo $id ?>" class="player" style="display: none; width: 100%; border-top: 0px;">
											<table style="width: 100%">
												<tr>
													<td style="width: 100%">
														<div id="player-bar-<?php echo $id?>" class="player-bar">
															<div id="load-bar-<?php echo $id?>" class="load-bar">
																<div id="play-bar-<?php echo $id?>" class="play-bar"></div>
															</div>
														</div>
													</td>
													<td>
														<div class="play-time"><img src="<?php echo asset_url('assets/i/ajax-loader.gif')?>" alt="..." /></div>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</label>
				</div>
			</fieldset>
			<?php endif; ?>
			
			<fieldset class="control-group">
				<label class="control-label" for="optionsCheckbox">
					<?php if($type == 'sms') { ?> Text Message <?php } else { ?> Transcription <?php } ?>
				</label>
				<div class="controls">
					<label class="checkbox">
						<div class="message-transcript"><?php echo (is_null($message->content_text) ? "(no transcription)" : $message->content_text) ?></div>
					</label>
				</div>
			</fieldset>
		</div>
	</form>

	<?php if($type == 'sms'): ?>
	<div style="padding-left: 10px;">
		<fieldset class="control-group">
			<label class="control-label" for="optionsCheckbox">Add Note</label>
			<div class="controls">
				<label class="checkbox">
					<form id="reply-sms" name="reply-sms" action="<?php echo site_url("messages/sms/$id") ?>" method="post">
						<h3>Reply</h3>
						<input type="hidden" name="from" value="<?php echo $called ?>" />
						<input type="hidden" name="to" value="<?php echo $caller ?>" />
						<textarea id="content" name="content"></textarea>
						<p class="count-desc"><span class="count">160</span> characters left</p>
						<button class="submit-button"><span>Send SMS</span></button>
						<img class="loader hide" src="<?php echo asset_url('assets/i/ajax-loader.gif')?>" alt="..." />

					</form>
					<ul id="message-details-notes-list">
						<?php foreach($annotations['items'] as $annotation): ?>
						<?php if($annotation->annotation_type == 'sms'): ?>
						<li class="note">
							<p class="note-created unformatted-relative-timestamp hide"><?php echo strtotime($annotation->created) ?></p>
							<div class="note-header">
								<?php
									if ($gravatars)
									{
										echo '<img class="gravatar" src="'.
											gravatar_url($annotation->email, 20, $default_gravatar).
											'" width="20" height="20">';
									}
								?>
								<p class="note-user-fullname"><?php echo $annotation->first_name ?> <?php echo $annotation->last_name ?></p>
								<p class="note-user-email"><?php echo $annotation->email ?></p>
							</div>
							<div class="note-content">
								<?php echo $annotation->description ?>
							</div>
						</li>
						<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</label>
			</div>
		</fieldset>
	</div>
	<?php endif; ?>
	
	<!--	
	<div class="vbx-content-container">
		<div class="message-details-notes">
			<form id="reply-sms" name="reply-sms" action="<?php echo site_url("messages/sms/$id") ?>" method="post">
				<h3>Reply</h3>
				<input type="hidden" name="from" value="<?php echo $called ?>" />
				<input type="hidden" name="to" value="<?php echo $caller ?>" />
				<textarea id="content" name="content"></textarea>
				<p class="count-desc"><span class="count">160</span> characters left</p>
				<button class="submit-button"><span>Send SMS</span></button>
				<img class="loader hide" src="<?php echo asset_url('assets/i/ajax-loader.gif')?>" alt="..." />

			</form>
			<ul id="message-details-notes-list">
				<?php foreach($annotations['items'] as $annotation): ?>
				<?php if($annotation->annotation_type == 'sms'): ?>
				<li class="note">
					<p class="note-created unformatted-relative-timestamp hide"><?php echo strtotime($annotation->created) ?></p>
					<div class="note-header">
						<?php
							if ($gravatars)
							{
								echo '<img class="gravatar" src="'.
									gravatar_url($annotation->email, 20, $default_gravatar).
									'" width="20" height="20">';
							}
						?>
						<p class="note-user-fullname"><?php echo $annotation->first_name ?> <?php echo $annotation->last_name ?></p>
						<p class="note-user-email"><?php echo $annotation->email ?></p>
					</div>
					<div class="note-content">
						<?php echo $annotation->description ?>
					</div>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	-->
		
	<?php if($type == 'voice'): ?>
	<div class="vbx-content-container">
		<div class="message-details-notes">
			<form id="add-annotation" name="add-annotation" action="<?php echo site_url("messages/details/$id/annotations") ?>" method="post">
				<h3>Notes <small>let you save information about your voicemail or SMS</small></h3>
				<table>
					<tbody>
						<tr>
							<td>
								<textarea id="description" name="description"></textarea>
							</td>
						</tr>
						<tr>
							<td style="text-align: right; border: 0px;">
								<input type="hidden" name="annotation_type" value="noted" />
								<button type="submit" class="submit-button btn primary">&nbsp; Add Note</button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			
		<?php if ($annotations['max'] > 0): ?>
			<p class="note-count">Showing <?php echo $annotations['max']; ?> of <?php echo $annotations['total']; ?></p>
		<?php else: ?>
			<p class="note-count">No Annotations</p>
		<?php endif; ?>
			<ul id="message-details-notes-list">
				<?php foreach($annotations['items'] as $annotation): ?>
				<li class="note">
					<p class="note-created unformatted-relative-timestamp hide"><?php echo strtotime($annotation->created) ?></p>
					<div class="note-header">
						<?php
							if ($gravatars)
							{
								echo '<img class="gravatar" src="'.
									gravatar_url($annotation->email, 20, $default_gravatar).
									'" width="20" height="20">';
							}
						?>
						<p class="note-user-fullname"><?php echo $annotation->first_name ?> <?php echo $annotation->last_name ?></p>
						<p class="note-user-email"><?php echo $annotation->email ?></p>
					</div>
					<div class="note-content">
						<?php echo $annotation->description ?>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		<?php if ($annotations['max'] > 0): ?>
			<p class="note-count">Showing <?php echo $annotations['max']; ?> of <?php echo $annotations['total']; ?></p>
		<?php endif; ?>
		
		</div><!-- .message-details-notes -->
	</div><!-- .vbx-content-container -->
	<?php endif; ?>

</div><!-- .vbx-content-main -->
