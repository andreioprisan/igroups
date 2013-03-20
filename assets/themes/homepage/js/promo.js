var promo_cart = new addon_cart();
var items = new Object();

$(document).ready(function(){
    makeLinksWork();

    //redraw_cart();

});


function promoCheckOut() {
    promo_cart.checkOut();
    //return false;
}

function addon_cart_item(domain){
    this.name = domain.domain;
    this.addons = domain.addons;
    this.addon_prices = domain.addon_prices;
    this.cycle = domain.cycle;
    this.status = domain.status;
    this.privatization = domain.privatization;
    this.prices = null;

    switch(domain.sitelock) {
        case '0': this.sitelock = '0'; break;
	case '75':
	case '78':
	    this.sitelock = '1'; break;
	case '76':
	case '79':
	    this.sitelock = '2'; break;
	case '77':
	case '80':
	    this.sitelock = '3'; break;
	default:
	    this.sitelock = '0'; break;
    }

    this.options = new Object();
    this.options.term = domain.term.toString();
    this.options.sitelock = (this.options.sitelock ? this.options.sitelock : this.sitelock);
    this.options.private = (this.options.private ? this.options.private : domain.privatization);


    this.makeSiteLock = function(){ 
	var sl_html = '<tr><td><p class="promo bold">' + this.name + '</p></td><td>';

	sl_html += "<select name='sitelock' onchange='promo_cart.sitelockize(\""+this.name+"\",this.value)' style='width:360px;'>";
	sl_html += "<option value='0'" + (this.options.sitelock == '0' ? ' selected' : '') + ">Not Subscribed" + this.getSiteLockPriceText(0) + "</option>";
	sl_html += "<option value='1'" + (this.options.sitelock == '1' ? ' selected' : '') + ">SiteLock Basic" + this.getSiteLockPriceText(1) + "</option>";
	sl_html += "<option value='2'" + (this.options.sitelock == '2' ? ' selected' : '') + ">SiteLock Premium" + this.getSiteLockPriceText(2) + "</option>";
	sl_html += "<option value='3'" + (this.options.sitelock == '3' ? ' selected' : '') + ">SiteLock SMB/Enterprise" + this.getSiteLockPriceText(3) + "</option>";
	sl_html += '</select></td></tr>';

        return sl_html;
    };

    this.makePrivatization = function(){ 
	//this.getAddonPrices();
	var pr_html = '<tr><td><p class="promo bold">' + this.name + '</p></td><td>';

	if (this.hasAddon("privacy")){
	    pr_html += "<select name='privatization' onchange='promo_cart.privatize(\""+this.name+"\",this.value)' style='width:280px;'>";
	    pr_html += "<option value='0'" + (this.options.private == '0' ? ' selected' : '') + ">Disabled</option>";
	    pr_html += "<option value='1'" + (this.options.private == '1' ? ' selected' : '') + ">Enabled - " + this.getPrivatizationPriceText(1) + "</option>";
	    pr_html += '</select>';
	} else {
	    pr_html += "N/A";
	}

        return pr_html;
    };


    this.getPrivatizationPrice = function() {
	var price = 0;
	if(this.options.private != '0') {
	    price = parseFloat(all_prices.addons.privacy[this.options.private-1]);
	    //switch(this.options.term) {
	    //case '1': price = this.addon_prices.privacy.term1; break;
	    //case '2': price = this.addon_prices.privacy.term2; break;
	    //case '3': price = this.addon_prices.privacy.term3; break;
	    //}
	}

	return price;
    };

    this.getPrivatizationPriceText = function(level){ 
	level = level.toString();
	var price_text = '';
	var term_text = '';

	if(this.cycle == 'month') {
	    term_text = 'monthly';
	} else {
	    switch(this.options.term) {
		case '1': term_text = 'yearly'; break;
		default: term_text = 'every ' + this.options.term + ' years'; break;
	    }
	}

    if (level > 0){
        price_text += makePrice(roundVal(all_prices.addons.privacy[this.options.term-1])) + ' ' + term_text; 
    }
	//switch(level) {
    //  case '0': break;
	//    case '1': price_text += "$" + roundVal(this.addon_prices.privacy['term'+this.options.term]) + ' ' + term_text; break;
	//}

	if(this.privatization == level) {
	    price_text += ' (subscribed)';
	}

	return price_text;
    };

    this.getSiteLockPrice = function() {
	var price = 0;
        if (this.options.sitelock) {
	        price += parseFloat(all_prices.addons.sitelock["lv" + this.options.sitelock][this.options.term-1]);
            //switch(this.options.sitelock) {
	        //    case '1': price += this.addon_prices.sitelock.lv1 * this.options.term; break;
	        //    case '2': price += this.addon_prices.sitelock.lv2 * this.options.term; break;
	        //    case '3': price += this.addon_prices.sitelock.lv3 * this.options.term; break;
            //}
        }
	return price;
    };

    this.getSiteLockPriceText = function(level){ 
	level = level.toString();
	var price_text = '';
	var term_text = '';

	if(this.cycle == 'month') {
	    term_text = 'monthly';
	} else {
	    switch(this.options.term) {
		case '1': term_text = 'yearly'; break;
		default: term_text = 'every ' + this.options.term + ' years'; break;
	    }
	}

    if (level > 0){
	    price_text += ' - ' + makePrice(all_prices.addons.sitelock["lv" + level][this.options.term-1]) + ' ' + term_text;
    }

	//switch(level) {
	//    case '0': break;
	//    case '1': price_text += ' - $' + roundVal(this.addon_prices.sitelock.lv1 * this.options.term) + ' ' + term_text; break;
	//    case '2': price_text += ' - $' + roundVal(this.addon_prices.sitelock.lv2 * this.options.term) + ' ' + term_text; break;
	//    case '3': price_text += ' - $' + roundVal(this.addon_prices.sitelock.lv3 * this.options.term) + ' ' + term_text; break;
	//}

	if(this.sitelock == level && this.sitelock > 0) {
	    price_text += ' (subscribed)';
	}


	return price_text;
    };

    this.hasAddon = function(addonname){
        for (var addon in this.addons){
            if (this.addons[addon] == addonname) {  return true; }
        }
        return false;
    };

}


function addon_cart(item, domain){
    var count = 0;

    $.getJSON("/service/ajax/lookup?type=addons" , function(data){
	//this.membername = data.membername;
	//this.email = data.email;
	//this.penta = data.penta_server;
	$('#loadingdomains').hide();

	if(data) {
	    $.each(data.domain_list, function(i,n) {
	        count++;
		items[n.domain] = new addon_cart_item(n);
	    });
	    redraw_cart();
	}
    });
    
    this.privatize = function(domain, level) {
	var default_private = '0';
	items[domain]['options']['private'] = ( level ? level : default_private );
    };

    this.sitelockize = function(domain, level) {
	var default_sitelock = '0';
	items[domain]['options']['sitelock'] = ( level ? level : default_sitelock );
    };


    this.renderPrivacy = function() {
	var myhtml = '';
	//var compare_url = '<a href="http://www.pd.domains.lycos.com/sitelock_compare_plans.html" class="promo">Compare SiteLock Plans</a><br><br>';
	var promo_text = '';
	var last_domain = '';
	var privacy_count = 0;
	var domaincount = 0;

	var pr_list = '<table border=0>';
	$.each(items, function(i, item) {
	    domaincount++;
	    pr_list += item.makePrivatization();
        });
	pr_list += '</table>';

	if(domaincount > 1) {
	    promo_text += '<h2 class="promo" style="color:#b00;">YES! Please add Domain Privacy to my domains:</h2>';
	} else if(domaincount == 1) {
	    promo_text += '<h2 class="promo">YES! Please add Domain Privacy to my domain <span style="color:#b00;">' + last_domain + '</span></h2>';
	}

	myhtml += promo_text;
	//myhtml += compare_url;

	myhtml += pr_list;
	return myhtml;
    };


    this.renderSiteLock = function() {
	var myhtml = '';
	var compare_url = '<a href="http://www.pd.domains.lycos.com/sitelock_compare_plans.html" class="promo">Compare SiteLock Plans</a><br><br>';
	var promo_text = '';
	var last_domain = '';
	var privacy_count = 0;
	var sitelock_count = 0;
	var domaincount = 0;

	var sl_list = '<table border=0>';
	$.each(items, function(i, item) {
	    domaincount++;
	    last_domain = item.name;
	    //var price = item.getPrice();
	    sl_list += item.makeSiteLock();
        });
	sl_list += '</table>';

	if(domaincount > 1) {
	    promo_text += '<h2 class="promo" style="color:#b00;">YES! Please add SiteLock to my domains:</h2>';
	} else if(domaincount == 1) {
	    promo_text += '<h2 class="promo">YES! Please add SiteLock to my domain <span style="color:#b00;">' + last_domain + '</span></h2>';
	}

	myhtml += promo_text;
	myhtml += compare_url;

	myhtml += sl_list;
	return myhtml;
    };

    this.renderSum = function(){
        var myhtml = '<div id="sum">Total: ';
        var sum = 0.0;
        var month_sum = 0.0;
        var sum2 = 0.0;
        var sum3 = 0.0;
        var sum4 = 0.0;
        var sum5 = 0.0;
	var sumtext = '';

        var count = 0;
        $.each(items, function(i, item) {
            if(item.cycle == 'month') {
		month_sum += parseFloat(item.getPrice());
	    } else {
		switch(item.options.term) {
		case '1': sum += parseFloat(item.getPrice()); break;
		case '2': sum2 += parseFloat(item.getPrice()); break;
		case '3': sum3 += parseFloat(item.getPrice()); break;
		case '4': sum4 += parseFloat(item.getPrice()); break;
		case '5': sum5 += parseFloat(item.getPrice()); break;
		}
	    }
            count++;
        });

	if(sum != 0) {
	    sumtext += '$' + roundVal(sum) + ' yearly';
	}
	if(sum2 != 0) {
	    if(sumtext != '') { sumtext += ', '; }
	    sumtext += '$' + roundVal(sum2) + ' every two years';
	}
	if(sum3 != 0) {
	    if(sumtext != '') { sumtext += ', '; }
	    sumtext += '$' + roundVal(sum3) + ' every three years';
	}
	if(sum4 != 0) {
	    if(sumtext != '') { sumtext += ', '; }
	    sumtext += '$' + roundVal(sum4) + ' every four years';
	}
	if(sum5 != 0) {
	    if(sumtext != '') { sumtext += ', '; }
	    sumtext += '$' + roundVal(sum5) + ' every five years';
	}
	if(month_sum != 0) {
	    if(sumtext != '') { sumtext += ', '; }
	    sumtext += '$' + roundVal(month_sum) + ' monthly';
	}

	if(sumtext == '') { sumtext = 'no change'; }

	myhtml += sumtext + '</div>';
        return myhtml;
    };


    this.checkOut = function() {
        var myJSONText = JSON.stringify(items);
        $.getJSON("/service/ajax/checkout", { json: myJSONText }, function(data){
	    if(! data) {
		// They prolly aren't logged in; send them to the login page.
		window.location = "/bin/ajax/login?username=&redirect=" + window.location;
            } else if (data.url != ""){
		// Send them to Registration.
		window.location = data.url;
	    } else if(promo_cart.itemCount() == 0) {
		// They don't have any domains; send them home?
		window.location = "/";
	    } else {
		// They didn't change anything.
		alert("There are no changes to your service.");
	    }

        }, "text");
    };


    this.itemCount = function() {
        var size = 0, key;
        for (key in items) {
            if (items.hasOwnProperty(key)) size++;
        }
        return size;
    };

}


function redraw_cart() {
    var sl_html = promo_cart.renderSiteLock();
    var pr_html = promo_cart.renderPrivacy();

    $("#sl_domain_list").html(sl_html);
    $("#pr_domain_list").html(pr_html);
}

function roundVal(val){
    var dec = 2;
    var result = Math.round(val*Math.pow(10,dec))/Math.pow(10,dec);
    if(result == 0) { return '0.00'; }
    result = result.toString();
    if (result.length == (result.indexOf('.') + 2)){
      result += "0";
    }
    if(result == parseInt(result)) {
	result += ".00";
    }

    return result;
}
