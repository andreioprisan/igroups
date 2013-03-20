<?php
	$class = 'numbers-blank';
	if($count_real_numbers > 0)
	{
		$class .= ' hide';
	}
?>
<div class="<?php echo $class; ?>">
	<h2>It looks like you don't have any phone numbers!</h2>
	<p>You can get toll-free or local numbers in your area code.</p>
	<button class="btn primary add number addnewnumber"><span>Get a Number</span></button>
</div>