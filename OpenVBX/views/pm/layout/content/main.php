<div class="row" style="padding-left: 10px; height: 100%;">
	<div class="span8" id="pane1" style="background-color: gray; padding-left: 20px; padding-top: 60px; width: 1000px; min-height: 603px; height: 100%; background: white; -moz-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -webkit-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -o-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); top: 0;
	">
	
		<div id="toolbar" style="padding: 5px 10px; height: 34px; width: 1006px; z-index: 10; padding-left: 20px; background: rgba(218, 218, 218, 0.8); border-bottom: 1px solid #CCC; position: fixed; top: 0; left: 240px; -moz-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -webkit-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); -o-box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5); box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.5);"><h2 style="display:inline;">Dashboard</h2><div id="toolbar_right" style="float:right; padding-top:4px; display:inline"></div></div>

		<div id="jsin"><?php $this->load->view('layout/content/modules/file_init', array('user_id' => $this->user_id, 'group_id' => $this->group_id, 'fullname' => '<?= fullname ?>'));
	
	?></div>
			<div id="pane1content">
				
				
				
				<div id='tasko'>
					<div class="invs" id="search_box_container"></div>
				    <div class="invs" id="search_query">&nbsp;</div>

				    <div id="search_box_container2"></div>
				    <div id="search_query2">&nbsp;</div>

				</div>
				
				<!--
				<iframe height="100%" id="my_iframe"
				allowTransparency="true" frameborder="0"
				scrolling="no" style="width:100%;border:none"
				src="http://igrou.ps.dev/igroupsc/slim/" title="form">machform</iframe>
				-->
				
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
			<form id="mr_form" onsubmit="return false;">
			<input type="hidden" name="id" id="id" value="">
			<input type="hidden" name="type" id="type" value="">
		          <div class="modalrightpane-header">
		            <a href="#" class="close primary" onClick="$('#modalrightpane').fadeOut('fast'); maxPane1(dashboard);">×</a>
		            <h3 id="mr-header-value">add member</h3>
		          </div>
		          <div class="modalrightpane-body">
		            <fieldset>
					<div class="clearfix" id="mr_e1_textd" style="display: none">
						<label for="mr_e1_text" style="text-align: left;" id="mr_e1_label"></label>
						<div class="input" style="display: block; padding-top: 8px" id="mr_e1_text"></div>
					</div>
					<div class="clearfix" id="mr_e2_textd" style="display: none">
						<label for="mr_e2_text" style="text-align: left;" id="mr_e2_label"></label>
						<div class="input" style="display: block; padding-top: 8px" id="mr_e2_text"></div>
					</div>
					<div class="clearfix" id="mr_e3_textd" style="display: none">
						<label for="mr_e3_text" style="text-align: left;" id="mr_e3_label"></label>
						<div class="input" style="display: block; padding-top: 8px" id="mr_e3_text"></div>
					</div>
					<div class="clearfix" id="mr_e4_textd" style="display: none">
						<label for="mr_e4_text" style="text-align: left;" id="mr_e4_label"></label>
						<div class="input" style="display: block; padding-top: 8px" id="mr_e4_text"></div>
					</div>
					<div class="clearfix" id="mr_e5_textd" style="display: none">
						<label for="mr_e5_text" style="text-align: left;" id="mr_e5_label"></label>
						<div class="input" style="display: block; padding-top: 8px" id="mr_e5_text"></div>
					</div>
					
					<div class="clearfix" id="mr_e11_inputd" style="display: none">
						<label for="mr_e11_input" style="text-align: left;" id="mr_e11_label"></label>
						<div class="input"><input class="xlarge" id="mr_e11_input" name="mr_e11_input" size="30" type="text"></div>
					</div>
					<div class="clearfix" id="mr_e11_inputd" style="display: none">
						<label for="mr_e12_input" style="text-align: left;" id="mr_e12_label"></label>
						<div class="input"><input class="xlarge" id="mr_e11_input" name="mr_e12_input" size="30" type="text"></div>
					</div>
					<div class="clearfix" id="mr_e11_inputd" style="display: none">
						<label for="mr_e13_input" style="text-align: left;" id="mr_e13_label"></label>
						<div class="input"><input class="xlarge" id="mr_e11_input" name="mr_e13_input" size="30" type="text"></div>
					</div>
					<div class="clearfix" id="mr_e11_inputd" style="display: none">
						<label for="mr_e14_input" style="text-align: left;" id="mr_e14_label"></label>
						<div class="input"><input class="xlarge" id="mr_e11_input" name="mr_e14_input" size="30" type="text"></div>
					</div>
					<div class="clearfix" id="mr_e11_inputd" style="display: none">
						<label for="mr_e15_input" style="text-align: left;" id="mr_e15_label"></label>
						<div class="input"><input class="xlarge" id="mr_e11_input" name="mr_e15_input" size="30" type="text"></div>
					</div>
					
		            </fieldset>
		          </div>
		          <div class="modalrightpane-footer">
					<!--

					<div class="clearfix" id="mr_div_elem2">
						<label for="mr_div_elem2_input" style="text-align: left;" id="mr_div_elem2_text">First Name</label>
						<div class="input">
							<input class="xlarge addmemberformtext" id="mr_div_elem2_input" name="mr_div_elem2_input" size="30" type="text">
						</div>
					</div>


		            <input type="submit" class="btn primary addmemberformsubmitbutton" value="Save" id="addmemberformsubmit">
		            <div class="input-prepend">
		              <label class="add-on "><input type="checkbox" name="is_admin" id="is_admin" value="1" class="addmemberformtext"></label>
		              <input class="mini" id="is_admintxt" name="is_admintxt" size="32" length="32" type="text" value="Make Administrator" style="width: 116px;">
		            </div>
					-->
		          </div>
				</form>
			</div>
			

			
	</div>
	</div>
</div>
