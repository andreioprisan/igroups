<div id="resultspage">

		<div id="searchresults" class="bluebox">
			<h2 class="bluebox"><?= $this->lang->line('us_en_search_results'); ?></h2>
			<div class="blueboxcontent">
				<div style="float:left; text-align:center; padding:10px 20px;text-align:left;">
					<span id="searchblurb" class="resulttext"></span>
					<table id='regular' class='tablesorter'>
					<thead>
						<tr>
							<th class="domain" style='width:400px;'><?= $this->lang->line('us_en_domain'); ?></th>
							<th class="prices" style='width:100px;'><?= $this->lang->line('us_en_price'); ?></th>
							<th class="status" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_action'); ?> | <?= $this->lang->line('us_en_status'); ?></th>
							<th class="type" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_type'); ?></th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot></tfoot>
					</table>
					<span id="regulardomaincostwarning" class="resulttext"></span>
				</div>
				<br style="clear:both;"/>
			</div>
			<button class="yellowbutton viewcart ui-corner-all" onclick="showCart()"><?= $this->lang->line('us_en_view_shopping_cart'); ?></button>
		</div>

		<div id="otherresults" class="bluebox">
			<ul>
				<li class="bluebox"><a href="#sect_international"><?= $this->lang->line('us_en_int'); ?></a></li>
				<li class="bluebox"><a href="#sect_premium"><?= $this->lang->line('us_en_premium'); ?></a></li>
				<li class="bluebox"><a href="#sect_suggested"><?= $this->lang->line('us_en_suggested'); ?></a></li>
			</ul>
			<div class="blueboxcontent">
				<div style="float:left; text-align:left; ">
					<div id="sect_international">
 						<span class="resulttext"><?= $this->lang->line('us_en_international_details'); ?></span>
 						<table id='international' class='tablesorter'>
						<thead>
							<tr>
							<th class="domain" style='width:400px;'><?= $this->lang->line('us_en_domain'); ?></th>
							<th class="prices" style='width:100px;'><?= $this->lang->line('us_en_price'); ?></th>
							<th class="status" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_action'); ?> | <?= $this->lang->line('us_en_status'); ?></th>
							<th class="type" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_type'); ?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot><tr><td colspan='3'>&nbsp;</td></tr></tfoot>
						</table>
						<span id="internationaldomaincostwarning" class="resulttext"></span>
					</div>

					<div id="sect_premium">
						<span class="resulttext"><?= $this->lang->line('us_en_business_details'); ?></span>
 						<table id='premium' class='tablesorter'>
						<thead>
							<tr>
							<th class="domain" style='width:400px;'><?= $this->lang->line('us_en_domain'); ?></th>
							<th class="prices" style='width:100px;'><?= $this->lang->line('us_en_price'); ?></th>
							<th class="status" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_action'); ?> | <?= $this->lang->line('us_en_status'); ?></th>
							<th class="type" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_type'); ?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot><tr><td colspan='3'>&nbsp;</td></tr></tfoot>
						</table>
					</div>
							
					<div id="sect_suggested">
						<span class="resulttext"><?= $this->lang->line('us_en_suggested_details'); ?></span>
 						<table id='suggested' class='tablesorter'>
						<thead>
						<tr>
							<th class="domain" style='width:400px;'><?= $this->lang->line('us_en_domain'); ?></th>
							<th class="prices" style='width:100px;'><?= $this->lang->line('us_en_price'); ?></th>
							<th class="status" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_action'); ?> | <?= $this->lang->line('us_en_status'); ?></th>
							<th class="type" style='width:500px;text-align:center;'><?= $this->lang->line('us_en_type'); ?></th>
						</tr>
						</thead>
						<tbody></tbody>
						<tfoot><tr><td colspan='3'>&nbsp;</td></tr></tfoot>
						</table>
					</div>
				</div>
				<br style="clear:both;"/>
			</div>
			
			<button class="yellowbutton  ui-corner-all viewcart" onclick="showCart()"><?= $this->lang->line('us_en_view_shopping_cart'); ?></button>
		</div>
		
	</div>
