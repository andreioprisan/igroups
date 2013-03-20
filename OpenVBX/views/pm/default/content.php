	<div id="content">
		<div class="bluebox">
			<h1 class="bluebox"><?= $this->lang->line('us_en_search_adomains'); ?></h1>
			<div class="blueboxcontent">
				<div style="float:left; text-align:center; padding:5px;">
					<form onsubmit="return search('thin');" >
					<div class="searchbox" style="width:360px;float:left; text-align:left;">
						<input class="largesearch ui-corner-all" maxlength="63" type="text" id="frontsearch" onkeyup="updatesearchterm(this)" />
					</div>
					<input type="image" src="/images/btn_search_small.png" style="padding:3px;" value="Search"/>
					</form>

					<p id='tldprices' class="darkgreen heading bold" style="margin:7px 3px;padding-top:7px; clear:both; text-align:left;font-size:14px;"><?= $this->lang->line('us_en_com');?>: <?= $this->lang->line('us_en_com_price_1year'); ?> <span class="bold">&middot;</span> <?= $this->lang->line('us_en_com_price_2years'); ?> <span class="bold">&middot;</span> <?= $this->lang->line('us_en_com_price_3years'); ?></p>

				</div>
				<div style="float:right; text-align:center; margin: 7px 15px 7px 0">
					<img src="/images/image_alreadyowndomain.png"/><br/>
					<a class="bold" href="javascript:transferDomain();"><?= $this->lang->line('us_en_transfer_domain'); ?></a>
				</div>
				<hr style="margin:5px;width:608px; clear:both; color:#d0d0d0;"/>
				<div style="float:left;margin:10px 0 10px 10px; width:270px;">
					<p class="darkgreen heading bold"><?= $this->lang->line('us_en_bluebox1_heading'); ?></p>
					<ul style="margin-left:10px;">
						<li><?= $this->lang->line('us_en_bluebox1_li1'); ?></li>
						<li><?= $this->lang->line('us_en_bluebox1_li2'); ?></li>
						<li><?= $this->lang->line('us_en_bluebox1_li3'); ?></li>
						<li><?= $this->lang->line('us_en_bluebox1_li4'); ?></li>
						<li><?= $this->lang->line('us_en_bluebox1_li5'); ?></li>
					</ul>
				</div>
				<div style="float:right;">
					<img src="/images/image_homepage_dotcom.jpg"/>
				</div>
				<br style="clear:both;"/>
			</div>
		</div>

		<div class="bluebox">
			<h2 class="bluebox"><?= $this->lang->line('us_en_safe_online'); ?></h2>
			<div class="blueboxcontent">
				<div style="float:left;margin:10px;">
					<p class="darkgreen heading bold"><?= $this->lang->line('us_en_safe_online'); ?></p>
					<ul style="margin-left:10px;">
						<li><span class='bold'><a href="/promo_privacy.html"><?= $this->lang->line('us_en_domain_privacy'); ?></a></span> - <?= $this->lang->line('us_en_domain_privacy_details'); ?> (<a class='helplink' href='javascript:help("privacy")'><?= $this->lang->line('us_en_learn_more'); ?></a>)</li>
						<li><span class='bold'><a href="/promo_sitelock.html"><?= $this->lang->line('us_en_sitelock'); ?></a></span> - <?= $this->lang->line('us_en_sitelock_details'); ?> (<a class='helplink' href='javascript:help("sitelock")'><?= $this->lang->line('us_en_learn_more'); ?></a>)</li>
					</ul>
				</div>
				<br style="clear:both;"/>
			</div>
		</div>

		<div class="bluebox">
			<h2 class="bluebox"><?= $this->lang->line('us_en_new_feature_domain_parking_sedo'); ?></h2>
			<div class="blueboxcontent">
				<div style="float:left;margin:10px;">
			<p class="darkgreen heading bold"><?= $this->lang->line('us_en_new_feature_domain_parking_sedo_money'); ?></p>
			<ul style="margin-left:10px;">
						<li><span class='bold'><a href="/promo_cash_parking.html"><?= $this->lang->line('us_en_domain_parking_sedo'); ?></a></span> - <?= $this->lang->line('us_en_domain_parking_sedo_details'); ?> (<a class='helplink' href='/promo_cash_parking.html'><?= $this->lang->line('us_en_learn_more'); ?></a>)</li>
			</ul>
				</div>
				<br style="clear:both;"/>
			</div>
		</div>

		<div class="bluebox">
			<h2 class="bluebox"><?= $this->lang->line('us_en_about_lycos_domains'); ?></h2>
			<div class="blueboxcontent">
				<div style="float:left;margin:10px;">
					<p><?= $this->lang->line('us_en_about_lycos_domains_details'); ?></p>
				</div>
				<br style="clear:both;"/>
			</div>
		</div>
	</div>


