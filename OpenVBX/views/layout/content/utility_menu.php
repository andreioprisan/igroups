<div id="vbx-util-menu">
	<ul class="util-menu">
		<?php if($logged_in): ?>
		<li class="vbx-util-item"><span class="username"><?php echo $user->email ?></span></li>
		<?php endif; ?>





		<?php if(!empty($callerid_numbers)): ?>
		<?php foreach($callerid_numbers as $i => $number): ?>
			<li class="util-menu-item"><p class="<?php echo ($i >= 1)? 'hide' : '' ?>"><?php echo format_phone($number->phone) ?></p></li>
		<?php endforeach; ?>
		<?php endif; ?>


		<?php foreach($util_links as $key => $val): ?>
		<li class="vbx-util-item"><?php echo anchor($key, $val); ?></li>
		<?php endforeach; ?>
	</ul>
</div><!-- #vbx-util-menu .util-menu -->
