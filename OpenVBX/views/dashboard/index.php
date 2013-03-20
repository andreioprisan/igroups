<div class="summary clearfix">
	<div class="summary-block">
		<div class="value">
			<span class="container"><?= count($pnumbers) ?></span>
		</div>
		<div class="label">
			Phone Numbers Active
		</div>
	</div>

	<div class="summary-block">
		<div class="value">
			<span class="container" id="dashboard_smss_available"><?= $resources->sms_available; ?></span>
		</div>
		<div class="label">
			SMSs Left
		</div>
	</div>
	
	<div class="summary-block">
		<div class="value">
			<span class="container" id="dashboard_minutes_available"><?= $resources->minutes_available; ?></span>
		</div>
		<div class="label">
			Local Minutes Left
		</div>
	</div>
	
	<div class="summary-block">
		<div class="value">
			<span class="container" id="dashboard_tfminutes_available"><?= $resources->tfminutes_available; ?></span>
		</div>
		<div class="label">
			Toll Free Minutes Left
		</div>
	</div>
	
	<div class="summary-block">
		<div class="value">
			<span class="container" id="dashboard_balance">$<?= $resources->balance; ?></span>
		</div>
		<div class="label">
			Pay as You Go Balance
		</div>
	</div>
	
	<div class="summary-block" style="margin-top: 7px;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button id="button-funds-add" class="btn success">Add Funds</button> &nbsp;&nbsp;&nbsp;
	</div>
</div>

<div class="charts">
	
	<div class="section-header" style="height:0px;"></div>
	<?php if (count($callsdata) == 0) { ?>
	<h2>No Call Statistics Available <small>statistics are recorded instantly </small></h2>
	<?php } else { ?>
	<script type="text/javascript">
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
					defaultSeriesType: 'line',
					marginRight: 150,
					marginBottom: 25
				},
				title: {
					text: 'Call Usage',
					x: -20 //center
				},
				subtitle: {
					text: '',
					x: -20
				},
				xAxis: {
					categories: [<?php 
						$xaxis = array();
						foreach ($callsdata as $number => $dates) {
							foreach ($dates as $date => $count) {
								$xaxis[] = date("m/d/y", strtotime($date));
							}
						}
						
						$xaxisu = array_unique($xaxis);
						echo "'";
						echo implode("','", $xaxisu);
						echo "'";
						?>]
				},
				yAxis: {
					title: {
						text: 'Calls'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					formatter: function() {
			                return '<b>'+ this.series.name +'</b><br/>'+
							this.x +': '+ this.y +' Calls';
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: 0,
					y: 100,
					borderWidth: 0
				},
				series: [
				<?php foreach ($callsdata as $number => $dates) {
				?>
				{
					name: '<?= format_phone($number); ?>',
					data: [<?= implode(",", $dates) ?>]
				}, 
				<?php } ?>
				]
			});
			
			
		});
			
	</script>
	<div id="container" style="width: 90%; height: 320px; margin: 50px 0px 0px 40px"></div>
	<?php } ?>
	
	
	<div id="vbx-context-menu" class="context-menu" style="background: none;">
		<div class="notify <?php echo (isset($error) && !empty($error))? '' : 'hide' ?>">
		 	<p class="message">
				<?php if(isset($error) && $error): ?>
					<?php echo $error ?>
				<?php endif; ?>
				<a href="" class="close action"><span class="replace">Close</span></a>
			</p>
		</div>
	</div>
	
</div>

<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript">
<?php 	if(strstr($_SERVER['HTTP_REFERER'], ".dev")) { ?>
    Stripe.setPublishableKey('pk_8WfgWTYn3yxf1XvsIByNHApx3mGjh');
<?php } else { ?>
    Stripe.setPublishableKey('pk_0RlxC0NZXri9kuNqNORmFb1meVc33');
<?php } ?>
</script>
<div id="dialog-funds-add" title="Add Funds" class="hide dialog">
	<div class="error-message hide"></div>
	<form class="vbx-form" id="payment_form" onsubmit="return false;">
	<input type="hidden" name="id" />
	<input type="hidden" id="tenant_id" value="<?= $tenant_id ?>" />
	<input type="hidden" id="purchase_cardtype" value="<?php if (count($cards) == 0) { echo "new"; }?>" />
	<input type="hidden" id="purchase_cardid" value="" />
	<input type="hidden" id="purchase_planid" value="" />
	<input type="hidden" id="purchase_billing_name" value="" />
	<input type="hidden" id="purchase_billing_address" value="" />
	<input type="hidden" id="purchase_billing_zip" value="" />
	<input type="hidden" id="purchase_total_amount" value="9.99" />
	
	<div class="clearfix">

	<label for="prependedInput" style="padding-bottom: 10px;"><font size="3">Payment Method</font></label><br/><br/>
	<div class="input" id="cardslistchoose" style="margin: 0px; padding-top: 0px; display: inline; float: left; position: absolute; left: 180px; top: 0px">
		<div id="cardselector" class="btn-group" style="display:inline;">
			<?php 
			if (count($cards) > 0) {
				$showbillingdetails = false;
			} else {
				$showbillingdetails = true;
			}
			
			//$showbillingdetails = true;
			
			
			$selectedcard = 0;
			
			foreach ($cards as $card) { 
				$selectedcard++;
				?>
			<a class="btn " href="#" id="<?= $card->stripeCustomerID ?>"  onclick="$('#newbillingcontact').hide(); $('div#cardselector a.btn').removeClass('primary'); $(this).addClass('primary'); $('#purchase_cardtype').val('existing'); $('#purchase_cardid').val($(this).attr('id'));"><b><?= $card->type ?></b> <?= $card->last4 ?></a>
			<?php }?>
          	<a class="btn <?php if (count($cards) == 0) { echo "primary"; }?>" href="#" id="newcard" onclick="$('#newbillingcontact').show(); $('div#cardselector a.btn').removeClass('primary'); $(this).addClass('primary'); $('#purchase_cardtype').val('new'); "><b>add new card</b></a>
        </div>
		<!-- class="existingcard" onchange="hidenewbillingcard()" onclick="hidenewbillingcard()" onselect="hidenewbillingcard()" -->
		<!-- onchange="shownewbillingcard()" onclick="shownewbillingcard()" onselect="shownewbillingcard()" type="radio" name="newcard" id="cardchoose" value="new" -->
	</div>
	<br>
<script>

$('div#planselector a#1').addClass('primary'); 
$('#purchase_planid').val('1'); 
$('#purchase_total_amount').val('9.99');
$('#onetimeamount').val('9.99'); 
$('#totalamount').val('9.99');

obj = document.getElementById("onetimeamount");
if (obj)
{
	obj.onchange = function()
	{
		$('#purchase_total_amount').val($('#onetimeamount').val());
		$('#totalamount').val($('#onetimeamount').val());
	};
	obj.onchange();
}

obj = document.getElementById("billing_name");
if (obj)
{
	obj.onchange = function()
	{
		$('#purchase_billing_name').val(obj.value);
	};
	obj.onchange();
}

obj = document.getElementById("billing_addressline1");
if (obj)
{
	obj.onchange = function()
	{
		$('#purchase_billing_address').val(obj.value);
	};
	obj.onchange();
}

obj = document.getElementById("billing_addresszip");
if (obj)
{
	obj.onchange = function()
	{
		$('#purchase_billing_zip').val(obj.value);
	};
	obj.onchange();
}

</script>

	<label for="prependedInput" style="padding-bottom: 10px; display: inline; float: left;"><font size="3">Choose Plan</font></label>
	<div class="input" style="margin: 0px; padding-top: 0px; display: inline; float: left; position: relative;
	right: -76px;
	top: -5px;">
		<div id="planselector" class="btn-group" style="display:inline;">
          <a class="btn" href="#" id="1" onclick="$('div#planselector a.btn').removeClass('primary'); $(this).addClass('primary'); $('#purchase_planid').val($(this).attr('id')); $('#purchase_total_amount').val('9.99');$('#onetimeamount').val('9.99'); $('#totalamount').val('9.99');">Small</a>
          <a class="btn" href="#" id="2" onclick="$('div#planselector a.btn').removeClass('primary'); $(this).addClass('primary'); $('#purchase_planid').val($(this).attr('id')); $('#purchase_total_amount').val('29.99');$('#onetimeamount').val('29.99');$('#totalamount').val('29.99');">Medium</a>
          <a class="btn" href="#" id="3" onclick="$('div#planselector a.btn').removeClass('primary'); $(this).addClass('primary'); $('#purchase_planid').val($(this).attr('id')); $('#purchase_total_amount').val('49.99');$('#onetimeamount').val('49.99');$('#totalamount').val('49.99');">Large</a>
          <a class="btn" href="#" id="3" onclick="$('div#planselector a.btn').removeClass('primary'); $(this).addClass('primary'); $('#purchase_planid').val($(this).attr('id')); $('#purchase_total_amount').val('99.99');$('#onetimeamount').val('99.99');$('#totalamount').val('99.99');">Larger</a>
 		  <a class="btn" href="#" id="99" onclick="$('div#planselector a.btn').removeClass('primary'); $(this).addClass('primary'); $('#purchase_planid').val($(this).attr('id'));$('#onetimeamount').val('9.99'); $('#totalamount').val('9.99'); $('#purchase_total_amount').val('9.99');">or Amount</a>
        </div>
		<div id="onetimepayment" class="input-prepend" style="position: relative;left: 357px;top: -28px; display:block">
			<span class="add-on" style="width:10px">&nbsp;<font color="black">$</font></span>
			<input class="input-xlarge focused" id="onetimeamount" size="5" type="text" style="width: 40px;" placeholder="9.99">
		</div>

	</div>
	<br>
	<br>
	<br>
	
	<div id="newbillingcontact" style="display: <?php if ($showbillingdetails) { echo "block"; } else { echo "none"; }?>">
		<table>
		<tr>
			<td style="padding: 0px; border: 0px">
				<label for="prependedInput" style="padding-bottom: 10px;"><font size="3">Billing Information</font></label><br/><br/>
				<div class="input">
					<div class="input-prepend">
						<span class="add-on" style="width:60px">&nbsp;<font color="black">name</font>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<input class="large name required" id="billing_name" name="billing_name" size="30" type="text">
					</div>
				</div>
				<div class="input">
					<div class="input-prepend">
						<span class="add-on" style="width:60px;">&nbsp;<font color="black">address</font></span>
						<input class="large address-line1 stripe-sensitive required" autocomplete="on" id="billing_addressline1" name="billing_address-line1" size="40" type="text">
					</div>
				</div>
				<div class="input">
					<div class="input-prepend">
						<span class="add-on" style="width:60px">&nbsp;<font color="black">zip</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<input class="large address-zip stripe-sensitive required" id="billing_addresszip" name="billing_addresszip" size="40" type="text">
					</div>
				</div>
				<br>
		
			</td>
			<td width="50%" style="padding: 0px; border: 0px">
				<label for="prependedInput" style="padding-bottom: 10px;"><font size="3">Credit Card Details</font></label><br/><br/>
				<div class="input">
					<div class="input-prepend">
						<span class="add-on" style="width:60px">&nbsp;<font color="black">number</font>&nbsp;&nbsp;</span>
						<input class="large card-number" id="billing_card-number" name="billing_card-number" size="40" type="text" maxlength="20" autocomplete="off">
					</div>
				</div>
				<div class="input">
					<div class="input-prepend">
						<span class="add-on" style="width:60px">&nbsp;<font color="black">cvc</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<input class="large card-cvc" id="billing_card-cvc" name="billing_card-cvc" size="4" type="text" maxlength="4" autocomplete="off">
					</div>
				</div>
				<div class="input">
					<div class="input-prepend">
						<span class="add-on" style="width:60px">&nbsp;<font color="black">exp</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<div class="expiry-wrapper">
							<select class="card-expiry-month stripe-sensitive required valid" id="billing_card-expiry-month" style="width: 60px; ">
							<option value="1" selected="">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>
							<span> / </span>
							<select class="card-expiry-year stripe-sensitive required valid" id="billing_card-expiry-year" style="width: 60px; position: relative; top: -5px;" name="card-expiry-year" style="top: -5px; position: relative;"><option value="2012" selected="">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option></select>
						</div>
					</div>
				<br>
				</div>
			</td>
		</tr>
		</table>
	</div>


	<div style="display:block">
		<label for="prependedInput" style="padding-bottom: 10px; display: inline; float: left; position: absolute;
		left: 14px;"><font size="3">Total</font></label>
		<div class="input" style="margin: 0px; padding-top: 7px; display: inline; position: absolute; position: relative;">
			<div class="input-prepend" style="position: relative;left: 121px;top: -7px;">
				<span class="add-on" style="width:10px">&nbsp;<font color="black">$</font></span>
				<input class="large" id="totalamount" name="total" size="5" type="text" style="width: 40px; color:black;" value="4.99" disabled>
			</div>
		</div>
		<span class="payment-errors"></span>
	</div>
	


</div>


	</form>
</div>
