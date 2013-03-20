<div class="row" id="pane1contentrow">
  <div class="span12" id="dashboard_left">
	<div id="dashboardfeed_module">coming soon</div>
  </div>
  <div class="span4" id="dashboard_right">
	<h4>plan limits</h4>

	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 0" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">of 5</label>
			<label class="add-on-name"> active groups</label>
		</div>
	</div><br /><br />

	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 0" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">of 5</label>
			<label class="add-on-name"> archived groups</label>
		</div>
	</div><br /><br />

	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 1" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">of 3</label>
			<label class="add-on-name"> GB available</label>
		</div>
	</div><br /><br />

	<input type="button" class="btn primary disabled" value="3 GB plan"> 	
	<button data-controls-modal="paymentform_upgrade_plan" data-backdrop="true" data-keyboard="true" class="btn danger" onclick="getUserCards(<?= $user_id ?>);">upgrade</button>
	<br /><br />

	<div id="paymentform_upgrade_plan" class="modal hide fade">
		<form id="example-form" name="example-form" onsubmit="dovalidate(paymentid); return false;">
		
	            <div class="modal-header">
	              <a href="#" class="close">&times;</a>
	              <h3>upgrade plan and addons</h3>
	            </div>
	            <div class="modal-body">
	              	<p>
						<fieldset>
						<div class="clearfix">
							
							<label for="prependedInput">Payment Method</label>
							<div class="input" id='cardslistchoose' style="margin: 0px; padding-top: 5px;"></div>
							<br />
							
							<div id='newbillingcontact' style="display:none;">
								<label for="prependedInput">New Billing Contact</label>
								<div class="input">
									<div class="input-prepend">
										<span class="add-on" style="width:60px">&nbsp;<font color="black">name</font>&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<input class="large name required" id="name" name="name" size="30" type="text">
									</div>
								</div>
								<div class="input">
									<div class="input-prepend">
										<span class="add-on" style="width:60px">&nbsp;<font color="black">email</font>&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<input class="large email required" autocomplete="on" id="email" name="email" size="40" type="text">
									</div>
								</div>
								<div class="input">
									<div class="input-prepend">
										<span class="add-on" style="width:60px;">&nbsp;<font color="black">address</font></span>
										<input class="large address-line1 stripe-sensitive required" autocomplete="on" id="address-line1" name="address-line1" size="40" type="text">
									</div>
								</div>
								<div class="input">
									<div class="input-prepend">
										<span class="add-on" style="width:60px">&nbsp;<font color="black">zip</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<input class="large address-zip stripe-sensitive required" class="address-zip stripe-sensitive required" id="address-zip" name="address-zip" size="40" type="text">
									</div>
								</div>
								<br />
								<label for="prependedInput">New Credit Card</label>
								<div class="input">
									<div class="input-prepend">
										<span class="add-on" style="width:60px">&nbsp;<font color="black">number</font>&nbsp;&nbsp;</span>
										<input class="large card-number" id="card-number" name="card-number" size="40" type="text" maxlength="20" autocomplete="off" class="card-number stripe-sensitive required">
									</div>
								</div>
								<div class="input">
									<div class="input-prepend">
										<span class="add-on" style="width:60px">&nbsp;<font color="black">cvc</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<input class="large card-cvc" id="card-cvc" name="card-cvc" size="4" type="text" maxlength="4" autocomplete="off" class="card-cvc stripe-sensitive required" >
									</div>
								</div>
								<div class="input">
									<div class="input-prepend">
										<span class="add-on" style="width:60px">&nbsp;<font color="black">exp</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<div class="expiry-wrapper">
								                    <select class="card-expiry-month stripe-sensitive required" style="width: 60px;">
								                    </select>
								                    <script type="text/javascript">
								                        var select = $(".card-expiry-month"),
								                            month = new Date().getMonth() + 1;
								                        for (var i = 1; i <= 12; i++) {
								                            select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
								                        }
								                    </script>
								                    <span> / </span>
								                    <select class="card-expiry-year stripe-sensitive required" style="width: 60px;"></select>
								                    <script type="text/javascript">
								                        var select = $(".card-expiry-year"),
								                            year = new Date().getFullYear();

								                        for (var i = 0; i < 12; i++) {
								                            select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
								                        }
								                    </script>
								         </div>
									</div>
							
								<br/>
							</div>
							</div>
							
							<label for="prependedInput">Choose Plan</label>
							<div class="input" style="margin: 0px; padding-top: 0px;">
								<div class="input">
									<input type=radio name=plan id=plan value=6> 6GB 
									<input type=radio name=plan id=plan value=12> 12GB 
									<input type=radio name=plan id=plan value=50> 50GB 
									<input type=radio name=plan id=plan value=100> 100GB 
									<input type=radio name=plan id=plan value=cloud> cloud
								</div>
							</div>
							<br/>
							
							<label for="prependedInput">Total</label>
							<div class="input" style="margin: 0px; padding-top: 7px;">
								<div class="input">
									<b>$0.99</b>
								</div>
							</div>
							<span class="payment-errors"></span>


						</fieldset>
					</p>
	            </div>
	            <div class="modal-footer">
	              <button type="submit" class="btn primary" name="submit-button">Purchase</button>
	            </div>
			</form>
	          </div>

	

	<h4>usage</h4>
	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 5" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">groups</label>
		</div>
	</div><br /><br />
	
	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 2" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">GB</label>
			<label class="add-on-name"> storage</label>
		</div>
	</div><br /><br />

	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 2" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">GB</label>
			<label class="add-on-name"> bandwidth</label>
		</div>
	</div><br /><br />
	
	<h4>addons</h4>
	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 4" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">tasks</label>
		</div>
	</div><br /><br />
	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 4" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">messages</label>
		</div>
	</div><br /><br />
	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 4" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">calendars</label>
		</div>
	</div><br /><br />
	
	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 4" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">events</label>
		</div>
	</div><br /><br />
	
	<div class="input">
		<div class="input-append">
			<input class="reallysmall" type="text" style="width:18px;" value=" 4" style="background-color:red;" id="toolbar_counter_value">
			<label class="add-on" style="color:red;" id="toolbar_counter_name">files</label>
		</div>
	</div><br /><br />
	

  </div>
</div>

