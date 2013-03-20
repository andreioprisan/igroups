<div class="row" style="padding-left: 10px; height: 100%;">
	<div class="span8" id="pane1" style="background-color: gray; padding-left: 20px; padding-top: 60px; width: 1000px; min-height: 603px; height: 100%; background: white; -moz-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -webkit-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -o-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); top: 0;">
	
		<div id="toolbar" style="padding: 5px 10px; height: 34px; width: 1006px; z-index: 10; padding-left: 20px; background: rgba(218, 218, 218, 0.8); border-bottom: 1px solid #CCC; position: fixed; top: 0; left: 240px; -moz-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -webkit-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -o-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5);"><h2 style="display:inline;">Dashboard</h2><div id="toolbar_right" style="float:right; padding-top:4px; display:inline"></div></div>

		<div id="jsin"></div>
		<div id="pane1content">
			<?php if (isset($owner_id) && isset($group_id)) {
				$owner_group = array('owner_id' => $owner_id, 'group_id' => $group_id);
			} else {
				$owner_group = array('owner_id' => $owner_id);
			} 
			?>
		</div>
	</div>
	<div class="span9" id="pane2" style="float: top; position: fixed; height: 0%;left: 748px; top: 9px;">
		<div id="pane2content">
			<div id="modalrightpane" class="modalrightpane hide fade in" style="display: none; ">
			</div>
		</div>
	</div>
</div>
