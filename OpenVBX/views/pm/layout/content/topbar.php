

<div class="topbar">
  <div class="fill">
    <div class="container">
      <a class="brand" href="/igroupsc/"><!--<img src="/asset/images/groups.png" style="float:left;">-->igrou.ps</a>
      <ul class="nav">
		<li class="active"><a href="/igroupsc/">Dashboard</a></li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle"><?php if (isset($groups_data)) {?><font color="red"><?= count($groups_data);?></font><?php } ?> groups</a>
			<ul class="dropdown-menu">
				<?php if (isset($groups_data)) {?>
					<?php foreach ($groups_data as $groups_data_item) { ?>
						<?php if ($groups_data_item->is_active) {?>
							<li><a href="/igroupsc/group/<?= $groups_data_item->id; ?>"><?= $groups_data_item->name; ?></a></li>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				<li class="divider"></li>
				<li><a href="/igroupsc/groupsManage">Groups Dashboard</a></li>
			</ul>
		</li>
        <li><a href="#allserviceplans"><font color="red">2</font> messages</a></li>
      </ul>
	  <ul class="mid-nav">
		<li>
			<form class="pull-left" action=""  style="padding-left: 20px;padding-right: 20px;"><input type="text" placeholder="Search"></form>
		</li>
	  </ul>
	  <ul class="secondary-nav">
		<li class="dropdown" style="float: right;">
			<a href="#" class="dropdown-toggle"><?= $fullname; ?></a>
			<ul class="dropdown-menu">
				<li><a href="#">Profile</a></li>
				<li><a href="#">Password</a></li>
				<li class="divider"></li>
				<li><a href="<?= $logoutUrl ?>">Sign Out</a></li>
			</ul>
		</li>
	  </ul>
    </div>
  </div>
</div>