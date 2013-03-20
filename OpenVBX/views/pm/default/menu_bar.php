		<div id="nav" style="height:30px;">
			<ul class="nav ui-corner-all" >
				<li class="inline"><a class="navbutton" href="/index.html" target="_parent" id="purchase" onmouseover="$(this).children('img').attr('src','/images/navbar/text_white/purchase_white.png')" onmouseout="$(this).children('img').attr('src','/images/navbar/text_gray/purchase.png')" ><img src="/images/navbar/text_gray/purchase.png" alt="Purchase"/></a></li>
				<li class="inline"><a class="navbutton" href="/manage.html" target="_parent" id="manage" onmouseover="$(this).children('img').attr('src','/images/navbar/text_white/manage_white.png')" onmouseout="$(this).children('img').attr('src','/images/navbar/text_gray/manage.png')" ><img src="/images/navbar/text_gray/manage.png" alt="Manage"/></a></li>
				<li class="inline"><a class="navbutton" href="/adm/redirect/email/?skin=LycosDomains" target="_blank" id="email" onmouseover="$(this).children('img').attr('src','/images/navbar/text_white/email_white.png')" onmouseout="$(this).children('img').attr('src','/images/navbar/text_gray/email.png')" ><img src="/images/navbar/text_gray/email.png" alt="Email"/></a></li>
				<li class="inline"><a class="navbutton" href="https://help.lycos.com/kb_cat.php?id=3" target="_blank" id="faq" onmouseover="$(this).children('img').attr('src','/images/navbar/text_white/faq_white.png')" onmouseout="$(this).children('img').attr('src','/images/navbar/text_gray/faq.png')" ><img src="/images/navbar/text_gray/faq.png" alt="FAQ"/></a></li>
				<li class="inline inline_search hidden"><button onclick="showCart()" id='cartbutton' class="cart  ui-corner-all"><?= $this->lang->line('us_en_view_cart'); ?></button></li>
			</ul>
		</div>
		<script type="text/javascript">
			var where_regexp = /domains\.lycos\.([\.|\w]+)[:\/]/;
			var where_array = where_regexp.exec(window.location.href);
			if(where_array && where_array[1]) {
				if(where_array[1] == 'com') {
					if(GeoIP['COUNTRY_CODE'] == 'GB') {
						document.write("<div id='alert' style='margin: 10px 0 0 0; font-size:16px; font-weight:bold; '><?= $this->lang->line('us_en_uk_cost_for_us_com'); ?><a href='http://domains.lycos.co.uk/'><?= $this->lang->line('us_en_click_here'); ?></a>.</div>");
					}
				}
 			}
		</script>



