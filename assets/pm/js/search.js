var oocart = new shoppingcart();
var debugging = 0;
var multidomain = 0;
var cctld = 'com';
var search_cctld = '';
var TLDcost = new Array();
var maxresults;
var resultstotal = 0;
var displayCSDomainTxt = false;
var displayWarningOnLeftResults = false;

function roundVal(val){
    var dec = 2;
    var result = Math.round(val*Math.pow(10,dec))/Math.pow(10,dec);
    result = result.toString();
    if (result.length == (result.indexOf('.') + 2)){
      result += "0";
    }
    if(result == parseInt(result)) {
	result += ".00";
    }

    return result;
}

function removeFromCart(domain, type) {
    track("cart/remove/"+type);
    oocart.removeItem(domain);
    incartToggle(domain, false);
    redraw_cart();
}

function incartToggle(domain, incart) {
    if (incart == true){
        $(".search_"+domain.escapeDots()).children(".actions").children(".incart").show();
        $(".search_"+domain.escapeDots()).children(".actions").children(".addtocart").hide();
    	
    } else {
        $(".search_"+domain.escapeDots()).children(".actions").children(".incart").hide();
        $(".search_"+domain.escapeDots()).children(".actions").children(".addtocart").show();
        //var fieldname = "resultregular_andrei3001.com_status";
        //document.getElementById(fieldname).innerHTML = _("search_js_incart");
    }
}

function addManyToCart(domains){
    var domarray = domains.split(',');
    $.each(domarray, function(){
        oocart.addItem(this, "regular", {price:"12.95"});
    });

    track("cart/addmany/" + domarray.length );
    redraw_cart();
}

function addInternationalToCart(domain, form) {

    var params = new Object();
    params['domain'] = domain;
    params['set'] = 'requirement';

    var input =  $(form).find(":input");
    $.each(input, function(){
        if ($(this).attr("type") == "checkbox") {
            if ($(this).is(':checked')){
                params[$(this).attr("name")] =  $(this).val();
            }
        } else {
            params[$(this).attr("name")] =  $(this).val();
        }
    });

    $.getJSON("/bin/ajax/tldinfo" , params, function(data){
        if (!data.requirementErrors) {
            oocart.addItem(domain, "international", {price:data.price[0]});
            incartToggle(domain, true);
            redraw_cart();
            $.modal.close();
        } else {
/*
		for (error in data.requirementErrors)
		{
			alert(error+"|"+data.requirementErrors[error]);
		}
*/  
          alert(_("search_js_alert_invalid"));
        }
    });
    return false;
}

function buyInternationalNow(domain, form) {

    var params = new Object();
    params['domain'] = domain;
    params['set'] = 'requirement';

    var input =  $(form).contents().find(":input");
    $.each(input, function(){
        params[$(this).attr("name")] =  $(this).val();
    });



    $.getJSON("/bin/ajax/tldinfo" , params, function(data){
        if (!data.requirementErrors) {
 	    oocart.clearCart();
	    oocart.save();
            oocart.addItem(domain, "international", {price:data.price[0]});
            redraw_cart();
            $.modal.close();
        } else {
            alert(_("search_js_alert_invalid"));
	}
    });
    return false;
}

function addToCart(domain, type, extra) {
    if(oocart.itemCount() >= 5){ 
        alert(_("search_js_alert_cart"));
    } else {
        if (type == "suggested"){
            track("cart/add/" + type +"/"+extra);
            price = null;
            oocart.addItem(domain, type, {price:extra});
            incartToggle(domain, true);
            redraw_cart();
        } else if (type == "international"){
            track("cart/add/" + type +"/"+extra);
            $.getJSON("/bin/ajax/tldinfo" , { domain:domain, get:"requirementErrors" }, function(data){
                if (!data.requirementErrors) {
                    oocart.addItem(domain, type, {price:extra});
                    incartToggle(domain, true);
                    redraw_cart();
                } else {
                    showForm(domain);
                }
            });
        } else if (type == "transfer"){
            track("cart/add/" + type );
            oocart.addItem(domain, type, {auth:extra});
            incartToggle(domain, true);
            redraw_cart();
        } else {
            track("cart/add/" + type +"/"+extra);
            $.getJSON("/bin/ajax/tldinfo" , { domain:domain, get:"requirementErrors" }, function(data){
                if (!data.requirementErrors) {
                    oocart.addItem(domain, type, {price:extra});
                    incartToggle(domain, true);
                    redraw_cart();
                } else {
                    showForm(domain);
                }
            });

        }
        redraw_cart();
    }
}

function showCart() {
    var html = oocart.renderCart();
    $.modal.close();
    $.modal(html,{autoResize:[false], autoPosition:[false] });
    $('.cart').closest("#simplemodal-container").css("top","50px").css("position","absolute");
    $('.simplemodal-close').html(_("search_js_cart_close_and_continue"));
    $(window).unbind('resize.simplemodal'); // hack to disable simplemodal resizing
    if ($(window).width() >= 940){
        $('.cart').closest("#simplemodal-container").css("left", (($(window).width() - 760)/2)).css("top","50px");
    } else {
        $('.cart').closest("#simplemodal-container").css("left", "90px").css("top","50px");
    }
}

$(window).resize(function() { // hack for dynamic cart vertical align
    if ($(window).width() >= 940){
        $('.cart').closest("#simplemodal-container").css("left", (($(window).width() - 760)/2)).css("top","50px");
        $('#transferform').closest("#simplemodal-container").css("left", (($(window).width() - 760)/2)).css("top","50px");
        $('.tldform').closest("#simplemodal-container").css("left", (($(window).width() - 760)/2)).css("top","50px");
    }
    $("#simplemodal-overlay").css("width","100%").css("height","100%");
});

function checkall(addon, checked){
    $.each($("tr#"+addon+" td").last().children("input"), function (i, item){
        if (checked){
            addAddon($(item).val(),addon,1);
        } else {
            addAddon($(item).val(),addon,0);
        }
    });
}

function addAddon( domain, addon, value ) {
    track("cart/"+addon+"/"+value);
    if (addon == "privacy"){
        oocart.privatize(domain, value);
    } else if ( addon == "sitelock") {
        if (value == 1) {
            value = $("#sitelockselector option:selected").val();
        }
        oocart.sitelockize(domain, value);
    }

    redraw_cart();
}


function updateSitelocks(value){
    oocart.updateSitelocks(value);
    redraw_cart();
}

function updateTerm (domain, term) {
    track("cart/term/"+term);
    oocart.updateTerm(domain, term);
    redraw_cart();
    makeLinksWork();
}

function updateCartButton () {
    oocart.renderCart();
    $("button#cartbutton").html(_("search_js_cart") + " (" + oocart.getCount() + ") " + makePrice(oocart.getSum()));

    if (oocart.getCount() == 0) {
        $('button.viewcart').hide();
        $('button#cartbutton').hide();
        $.modal.close();
    } else {
        $('button.viewcart').show();
        $('button#cartbutton').show();
    }
}


function redraw_cart () {
    oocart.save();
    updateCartButton();
    if ($("table#cart").length){
        showCart();
    }
}

function buyOnly(domain,type,price){
    if (type == "suggested"){
        track("cart/buyonly/" + type +"/"+price);
        price = null;
    } else {
        track("cart/buyonly/" + type );
    }

    oocart.clearCart();
    oocart.save();
    view('cart');
    addToCart(domain, type, {price:price});
    
    $.modal.close();
}

function replacer(key, value) {
    if (typeof value === 'number' && !isFinite(value)) {
        return String(value);
    }
    return value;
}

function checkOut() {
    track("cart/checkout");
    oocart.save()
    oocart.checkOut();
}
   
var abtest = false;


$(document).ready(function(){
    // Set default search ccTLD based on filename.
    var tld_find_regexp = /_(\w{2,4})\.html/;
    var tld_find_regexp_array = [];
    tld_find_regexp_array = tld_find_regexp.exec(window.location.href);
    if(tld_find_regexp_array && tld_find_regexp_array[1]) {
	cctld = tld_find_regexp_array[1];
    }

    // Sanitize ccTLD for TLDs we have templatized.
    var tld_regexp = /^(com|uk|ca|eu|de|fr|nz|tv|au|co)$/;
    if(! tld_regexp.test(cctld)) { cctld = 'com'; }
    //showForm("test.com.au");

    // Set default search ccTLD based on server URL.
    var where_regexp = /domains\.lycos\.([\.|\w]+)[:\/]/;
    var where_array = where_regexp.exec(window.location.href);
    if(where_array && where_array[1]) {
	if(where_array[1] == 'co.uk' && cctld == 'com') {
	    //cctld = 'uk';
	}
    }

    getPrices();
    var price_cctld = cctld;
    switch(cctld) {
    case 'au':
	price_cctld = 'com.au'; break;
    case 'nz':
	price_cctld = 'co.nz'; break;
    case 'uk':
	price_cctld = 'co.uk'; break;
    }

    $(".inline_search").removeClass("hidden");
    setCountryPromo();


    if (countrycode_tld != "USA"){
        $('#premiumsearch').hide();
    }

    $("#navsearch input.navbutton").makeidletext("Search");
    $("#headersearch").makeidletext(_("search_js_yourdomain")+"."+cctld);
    $("#frontsearch").makeidletext(_("search_js_yourdomain")+"."+cctld);
    $("#premiumsearch").makeidletext(_("search_js_yourdomain")+"."+cctld);

    $("#regular").tablesorter({  headers: { 2: { sorter: false } } } );

    $("#international").tablesorter({ headers: { 2: { sorter: false } } } );
    $("#premium").tablesorter({ headers: { 2: { sorter: false } } } );
    //$("#suggested").tablesorter({ headers: { 1: { sorter: false }, 2: { sorter: false } } } );

   
    $('#otherresults').tabs();
  
    redraw_cart();
    $("body").css("overflow","visible");

    if (ip.charAt(ip.length-1) % 2 == 1){ abtest = true; }
    ab =  $(document).getUrlParam("abtest");
    if (ab == "a"){ abtest = true; }
    if (ab == "b"){ abtest = false; }
    
    if (abtest) {
        track("abtesting/a");
    } else {
        track("abtesting/b");
    }


    transf =  $(document).getUrlParam("transfer");
    if (transf){
        transferDomain(transf);
    } else {
        $(".searchresults").hide();
    }

    param =  $(document).getUrlParam("search");
    if (param){
        $("#domainsearch").val(param);
        searchterm = param;
        search();
    } else {
        $(".searchresults").hide();
    }
    var curtab = $(document).getUrlParam("tab");
    if (curtab) {
        view(curtab);
    }
 
    var autocart =  $(document).getUrlParam("cart");
    if (autocart){
      var autocartdomains = autocart.split(",");
      $.each(autocartdomains, function (domain){
          addToCart(autocartdomains[domain],"international");
          $("#domainsearch").val(autocartdomains[domain]);
      });
      search();
      view("cart"); 
      showCart();
    }
    
    makeLinksWork();  	

    updateCartButton();
//showCart();//for testing
});


var oldsearch = ''

function search(type){

    updateCartButton();
    $("#frontpage").hide();
    $("#resultspage").show();
    $("#headersearch").val(searchterm);
    $(".searchbox").each(function(){
        if ($(this).children("select").children(":selected").val() != undefined){
            $(this).children("select").children("option :contains('"+searchtld+"')").attr('selected', 'selected');

        }
    });

    var searchtermlc=searchterm.toLowerCase();
    searchterm = searchtermlc;
    var wwwreplace = searchterm.substr(0,4);
    if (wwwreplace == "www.")
    {
	searchterm = searchterm.substr(4);
    }
	
    var searchtermnsp = searchterm.replace(/\+/g, "");
    searchterm = searchtermnsp;

    if (searchterm != "" && searchterm != oldsearch ){
        track("search/" + searchterm);

	var allglobal_tld = /\.(ac|ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|asia|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cat|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|info|int|io|iq|ir|is|it|je|jm|jo|jobs|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mobi|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tel|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|travel|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|za|zm|zw)$/;
	var match_global_tlds = allglobal_tld.exec(searchterm);
	
	var match_global = false;
	if(match_global_tlds && match_global_tlds[1] != '') {
		match_global = true;
	}

	var match_ours = false;
	var cc_regexp = /\.(com|net|org|biz|info|uk|ca|eu|de|fr|tv|com.au|org.au|net.au|id.au|co.nz|net.nz|org.nz|gen.nz|geek.nz|co|mobi|name|asia|us|at|be|bz|cc|ch|com.mx|dk|es|it|li|me|nl|ws|tw|hk|ph|jp|gs|ms|vg|tc)$/;
	var temp_search_cctld = cc_regexp.exec(searchterm);
	
	if(temp_search_cctld && temp_search_cctld[1] != '') {
	    search_cctld = temp_search_cctld[1];
	    match_ours = true;
	} else {
	    search_cctld = cctld;
	}

	// if not a valid tld, replace spaces and . and send down as .com to search all domains	
	if (!match_global && !match_ours)
	{
		// take out all dots and spaces
		searchterm = searchterm.split('.').join('');         
		nomatches = true;
	} else if (match_global && !match_ours)
	{
		// if a tld we don't support, take out tld and still search across our results
		var indexforrealtld = searchterm.indexOf(match_global_tlds[1]);
		var newsearch = searchterm.substr(0, indexforrealtld-1);
		searchterm = newsearch.split('.').join('');

		// and display cs txt
		displayCSDomainTxt = true;
	}	
 
	if(cctld != 'com') {
	    // Change the search TLD as necessary for promo pages.
	    if(cc_regexp.test(searchterm)) {
		var gcc_regexp = /\.(com|net|org|biz|info)$/;
		var gcc_array = gcc_regexp.exec(searchterm);
		if(gcc_array && gcc_array[1] != '') {
		    // Change 'this.com' -> 'this.au'
		    searchterm = searchterm.replace(gcc_array[1], cctld);
		} else if(search_cctld && search_cctld != cctld) {
		    // Change 'this.fr' -> 'this.fr.au'
		    searchterm = searchterm + '.' + cctld;
		}
	    } else {
		// Change 'this' -> 'this.au'
		searchterm = searchterm + '.' + cctld;
	    }
	}

        oldsearch = searchterm;

        searchDomains("regular");
        searchDomains("international");

	searchSuggested();

//	setTimeout("searchDomains('suggested')",4000);  

	// DAMN YOU JAVASCRIPT, this actually doesn't work!
  
	// let the parallel ajax calls on home page load first
	// then request results on the suggested tab, which is not visible anyways
	// this was suggested won't slow down ohme page results
	
/*
	var domainsresultsfrontpage = 19;
	while (resultstotal < domainsresultsfrontpage)
	{
		// yes, javascript doesn't have a sleep function..
		var milliseconds = 5000;
		var start = new Date().getTime();
		while ((new Date().getTime() - start) < milliseconds){
			// Do nothing
		}
	}	

	if (resultstotal >= domainsresultsfrontpage)
	{
   		searchDomains("suggested");
        }
*/
	var types = ['premium'];
	var exclude = [];  // anything in here will be hidden from the page in case we dont have a contract to offer them in certain countries

        if (countrycode_tld != "USA"){
            exclude = ['premium'];
        }

        for (i=0; i < types.length; i++){
            if (types[i] in oc(exclude)){
                var hiddentab = '#sect_' + types[i];
                $(hiddentab).hide();
                $('a[href$="'+hiddentab+'"]').parents('li').hide();
                if (types[i] == "premium"){
                    $('#premiumsearch').hide();
                }
            } else {
                searchType(types[i]);
                if (type && types[i] == type) {
                    $('#otherresults').tabs('select', '#sect_' + type);
                }
            }
        }   
        $("span.resulttext").css("height",  $("span.resulttext").maxHeight()   );
        return false;
    }
}



var searchterm = "";
var searchtld = "";
function updatesearchterm(input){
    var searchbox = $(input).parent();
    searchterm = searchbox.children("input").val();
    if (searchbox.children("select").children(":selected").val() != undefined){
        searchterm += searchbox.children("select").children(":selected").val();
        searchtld = searchbox.children("select").children(":selected").val();
    }
}

function oc(a){
  var o = {};
  for(var i=0;i<a.length;i++){
    o[a[i]]='';
  }
  return o;
}

function searchSuggested()
{
	var justdomain;
	var totalavailable = new Array();
	var totalprice = 0.0;
	var count = 0;
	var type = "suggested";

	$("#" + type  + " tbody").html("<tr><td colspan=3 class='waiting'></td></tr>");
	$("#" + type).trigger("update");
	$("#" + type +" tfoot").html("<tr><td colspan='3'>&nbsp;</td></tr>");

	var startTLDpos = searchterm.indexOf('.');
	var pureDomainName;
	var pureFullTLD;

	if (currency == "UK")
	{
		var regularTLDs = new Array("co.uk", "com", "co", "net", "org", "tv", "biz", "info");//, "mobi", "name");
	} else if (currency == "USA") {
		var regularTLDs = new Array("com", "co", "net", "org", "tv", "biz", "info", "mobi", "name");
	} else if (currency == "AU") {
                var regularTLDs = new Array("com.au", "com", "co", "net.au", "net", "org.au", "org", "tv", "biz", "info", "mobi", "name");
        } else if (currency == "NZ") {
                var regularTLDs = new Array("co.nz", "com", "co", "net.nz", "net", "org", "org.nz", "tv", "biz", "info", "mobi", "name");
        }
	
	if (startTLDpos >= 0)
	{
		pureDomainName = searchterm.substring(0, startTLDpos);
		pureFullTLD = searchterm.substring(startTLDpos+1);
	} else if (startTLDpos == -1) {
		pureDomainName = searchterm;
		pureFullTLD = regularTLDs[0];
		// if no tld entered, just keyword, set max to domains count from left side (7)
	}
	
	var maxresults = regularTLDs.length;
	var cartlist = oc(oocart.domainList());
	
	$.getJSON("/bin/ajax/search" , { domain: pureDomainName, type: "suggested", currency:currency }, function(data)
	{
	        $("#" + type  + " tbody").html("");

		$.each(data.names, function(i,item)
		{
			if (item.available != "taken") {
				totalprice += parseFloat(item.price);
				totalavailable.push(item.name);
			}
	
			var tr = $("<tr id='result"+ type +"_"+item.name+"' class='search_"+item.name+"'></tr>");
			tr.append("<td id='result"+ type +"_"+item.name+"_name'>"+item.name+"</td>");
			tr.append("<td style='text-align:left;' id='result"+ type +"_"+item.name+"_price'>"+makePrice(item.price)+"</td>");

			var availStatus;
			if (item.available == "taken"){
				availStatus = " " + _("search_js_taken") + " ";
			} else {
/*
				availStatus = "<a class='addtocart' href='javascript:addToCart(\""+item.name+"\",\""+type+"\",\""+item.price+"\" )'>"+_("search_js_add_tocart")+"</a><span class='incart' style='display:none;'>" + _("search_js_incart") + "</span>";
		
				if (item.name in cartlist){
					availStatus = _("search_js_incart");
				}
*/
				var addToCartStyle = "";
				var inCartStyle = "";
				if (item.name in cartlist){
					addToCartStyle = "style='display:none;'";
                                } else {
					inCartStyle = "style='display:none;'";
				}
				availStatus = "<a class='addtocart' href='javascript:addToCart(\""+item.name+"\",\""+type+"\",\""+item.price+"\" )'" + addToCartStyle + ">"+_("search_js_add_tocart")+"</a><span class='incart'" + inCartStyle + ">" +_("search_js_incart") +"</span>";
			}
	
			var avail = $("<td style='text-align:center; font-color: gray;' class='actions' id='result"+ type +"_"+item.name+"_status'>"+ availStatus +"</td>");
			tr.append(avail);
			tr.append("<td class='type'></td>");
	
			$("#" + type + " tbody").append(tr);
	
			if (count >= maxresults){ 
			// hide some results for the show more button to unhide unless we are within two results of the full list
				$("#" + type + " tbody").children('tr').last().hide();
				$("#" + type + " tfoot").html("<tr><td colspan='3'><a class=\"bold\" href='javascript:moreResults(\""+type+"\")'>" + _("search_js_more", Array(_("search_js_"+type))) + "</a></td></tr>");
			} else {
				$("#" + type + " tfoot").html("<tr><td colspan='3'>&nbsp;</td></tr>");
			}
	
			count++;
			resultstotal++;
	
		});
	});

	if ( totalavailable.length > 0 ){
		$("#" + type + " tfoot").html("<tr><td colspan='3'>&nbsp;</td></tr>");
	}

	var sorting = [[3,1]];
	$("#" + type).trigger("update");
	$("#" + type).trigger("sorton",[sorting]);

}

function searchDomains(type) {
	var justdomain;
   	var totalavailable = new Array();
	var totalprice = 0.0;
	var count = 0;
        
	if (type == "regular")
	{
		if (displayCSDomainTxt)
		{
                        $("#searchblurb").printf(_("search_js_searchblurbcontactcs", Array(searchterm)));
		} else {
			$("#searchblurb").printf(_("search_js_searchblurb", Array(searchterm)));
		}		
	}

	//$('#regular tbody').html("<tr><td colspan=3 class='waiting'></td></tr>");
	$("#" + type).trigger("update");
	$("#" + type +" tfoot").html("<tr><td colspan='3'>&nbsp;</td></tr>");
   
	var startTLDpos = searchterm.indexOf('.');
	var pureDomainName;
	var pureFullTLD;

	if (countrycode_tld == "USA")
	{
                var regularTLDsLEFTSideUK = new Array("co.uk", "com", "co", "net", "org", "tv", "cc", "biz", "info", "me", "ws");//, "mobi", "name");
                var regularTLDsLEFTSideUSA = new Array("com", "co", "net", "org", "tv", "us", "cc", "biz", "info", "mobi", "name", "me", "ws");
                var regularTLDsRIGHTSideUSA = new Array("ca", "co.uk", "eu", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "com.au", "org.au", "net.au", "id.au", "co.nz", "net.nz", "org.nz", "gen.nz", "geek.nz");
                var regularTLDsRIGHTSideUK = new Array("ca", "eu", "us", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "com.au", "org.au", "net.au", "id.au", "co.nz", "net.nz", "org.nz", "gen.nz", "geek.nz");    


                var regularTLDsLEFTSideAU = new Array("com.au", "com", "co", "net.au", "net", "org.au", "org", "tv", "biz", "info", "mobi", "name");
                var regularTLDsRIGHTSideAU = new Array("ca", "co.uk", "eu", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "id.au", "co.nz", "net.nz", "org.nz", "gen.nz", "geek.nz");

                var regularTLDsLEFTSideNZ = new Array("co.nz", "com", "co", "net.nz", "net", "org", "org.nz", "tv", "biz", "info", "mobi", "name");
                var regularTLDsRIGHTSideNZ = new Array("ca", "co.uk", "eu", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "gen.nz", "geek.nz", "com.au", "org.au", "net.au", "id.au");


	} else {
                var regularTLDsLEFTSideUK = new Array("co.uk", "com", "co", "net", "org", "tv", "biz", "info", "me", "ws");//, "mobi", "name");
                var regularTLDsLEFTSideUSA = new Array("com", "co", "net", "org", "tv", "biz", "info", "mobi", "name", "me", "ws");
                var regularTLDsRIGHTSideUSA = new Array("ca", "co.uk", "eu", "us", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "com.au", "org.au", "net.au", "id.au", "co.nz", "net.nz", "org.nz", "gen.nz", "geek.nz");
                var regularTLDsRIGHTSideUK = new Array("ca", "eu", "us", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "com.au", "org.au", "net.au", "id.au", "co.nz", "net.nz", "org.nz", "gen.nz", "geek.nz");

                var regularTLDsLEFTSideAU = new Array("com.au", "com", "co", "net.au", "net", "org.au", "org", "tv", "biz", "info", "mobi", "name");
                var regularTLDsRIGHTSideAU = new Array("ca", "co.uk", "eu", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "id.au", "co.nz", "net.nz", "org.nz", "gen.nz", "geek.nz");
                var regularTLDsLEFTSideNZ = new Array("co.nz", "com", "co", "net.nz", "net", "org.nz", "org", "tv", "biz", "info", "mobi", "name");
                var regularTLDsRIGHTSideNZ = new Array("ca", "co.uk", "eu", "de", "asia", "at", "bz", "ch", "es", "hk", "li", "nl", "ph", "tw", "gen.nz", "geek.nz", "com.au", "org.au", "net.au", "id.au");

	}

        // in the US, move .us results to the left panel, otherwise show under .eu on right panel
        if (type == "regular" || type == "suggested")
        {
                if (currency == "UK") {
                        // No UK prices yet for mobi, name - exclude them from search
                        var regularTLDs = regularTLDsLEFTSideUK;
                } else if (currency == "USA") {
                        var regularTLDs = regularTLDsLEFTSideUSA;
 		} else if (currency == "AU") {
                        var regularTLDs = regularTLDsLEFTSideAU;
                } else if (currency == "NZ") {
                        var regularTLDs = regularTLDsLEFTSideNZ;
                }
        } else if (type == "international")
        {
                if (currency == "USA") {
                        var regularTLDs = regularTLDsRIGHTSideUSA;
                } else if (currency == "UK") {
                        var regularTLDs = regularTLDsRIGHTSideUK;
                } else if (currency == "AU") {
                        var regularTLDs = regularTLDsRIGHTSideAU;
		} else if (currency == "NZ") {
                        var regularTLDs = regularTLDsRIGHTSideNZ;
                }
        }

	if (startTLDpos >= 0)
	{
		pureDomainName = searchterm.substring(0, startTLDpos);
		pureFullTLD = searchterm.substring(startTLDpos+1);
	} else if (startTLDpos == -1) {
		pureDomainName = searchterm;
		pureFullTLD = regularTLDs[0];
		// if no tld entered, just keyword, set max to domains count from left side (7)
		if (type == "regular")
	        {
			maxresults = regularTLDs.length;
		}
	}
	
	if (type == "regular")
	{
		if (pureFullTLD == 'com.au' || pureFullTLD == 'org.au' || pureFullTLD == 'net.au' || pureFullTLD == 'id.au' || pureFullTLD == 'co.uk' || pureFullTLD == 'mobi' || pureFullTLD == 'co.nz')
		{
		        displayWarningOnLeftResults = true;
			$("#regulardomaincostwarning").append(_("search_js_searchblurb2yearcommitment"));
		}
	}

	if (!displayWarningOnLeftResults && type == "international")
	{
                $("#internationaldomaincostwarning").append(_("search_js_searchblurb2yearcommitment"));
	}

	var tldInRegularTLDsPosition = -1;	
	var orderedTLDs = new Array();

	// lets see if the searched term's TLD is in out TLD list
	for (var i=0,len=regularTLDs.length; tld=regularTLDs[i], i<len; i++)
        {
		if (tld == pureFullTLD)
		{
			tldInRegularTLDsPosition = i;
		}	
	}
	
	if (type == "regular")
	{
		if (tldInRegularTLDsPosition >= 0)
		{
			// domain with a tld equal from list, still count from lft side (7)
			maxresults = regularTLDs.length;
		} else {
			// otherwise, unknown tld, will become first on list, count incremented (8)
			maxresults = regularTLDs.length + 1;
		}
	}

        if (tldInRegularTLDsPosition <= 0)        
	{               
		if (tldInRegularTLDsPosition == -1)
		{
			// no match
			orderedTLDs.push(pureFullTLD);
			for (var i=0,len=regularTLDs.length; tld=regularTLDs[i], i<len; i++)
			{
				orderedTLDs.push(tld);
			}
				
		} else {
			// .com first, don't reorder
			orderedTLDs = regularTLDs;        					
		}
	} else if (tldInRegularTLDsPosition > 0){                
		orderedTLDs.push(regularTLDs[tldInRegularTLDsPosition]);
                
		for (var i=0,len=regularTLDs.length; tld=regularTLDs[i], i<len; i++)
                {
                        if (i != tldInRegularTLDsPosition)
                        {
                                orderedTLDs.push(tld);
                        }
                }
        }


	// start building response table
	for (var i=0, len=orderedTLDs.length; val2=orderedTLDs[i], i<len; i++)
	{
	    if (type == "international" && val2 == pureFullTLD)
	    {
		continue;
	    }
	
                var domain_name = pureDomainName + "." + val2;
	        var item;

		var extra1 = '';
		var extra2 = '';
		if (searchterm == domain_name)
		{
			extra1 = '<b>';
			extra2 = '</b>';
		}

	        var tr = $("<tr id='result"+ type +"_"+domain_name+"' class='search_"+domain_name+"'></tr>");
                tr.append("<td id='result"+ type +"_"+domain_name+"_name'>"+extra1+""+domain_name+""+extra2+"</td>");
	        tr.append("<td style='text-align:left;' id='result"+ type +"_"+domain_name+"_price'>"+extra1+""+_("search_js_searchingprice")+""+extra2+"</td>");
            
                var avail = $("<td style='text-align:center; font-color: gray;' class='actions' id='result"+ type +"_"+domain_name+"_status'>"+extra1+""+_("search_js_checkingavailability")+""+extra2+"</td>");
                tr.append(avail);
                tr.append("<td class='type'></td>");
         
                $("#" + type + " tbody").append(tr);
   
		if (count >= maxresults){ // hide some results for the show more button to unhide unless we are within two results of the full list
                    $("#" + type + " tbody").children('tr').last().hide();
                    $("#" + type + " tfoot").html("<tr><td colspan='3'><a class=\"bold\" href='javascript:moreResults(\""+type+"\")'>" + _("search_js_more", Array(_("search_js_"+type))) + "</a></td></tr>");
                } else {
                    $("#" + type + " tfoot").html("<tr><td colspan='3'>&nbsp;</td></tr>");
                }

		count++;
		resultstotal++;
 	}

        $.getJSON("/bin/ajax/tldcost" , { currency:currency }, function(data){
            for (var i=0, len=orderedTLDs.length; val=orderedTLDs[i], i<len; i++)
            {
                  if (type == "international" && val == pureFullTLD)
                  {
                         continue;
                  }

                  var costDomain = 0;
		  var showPerYearWarning = 0;
                  if (val == "co.uk")
                  {
                          showPerYearWarning = 1;
		          costDomain = '12.95';
        //                 costDomain = data.domains[val][1];
                  } else if (val == "org.au" || val == "com.au" || val == "net.au" || val == "id.au" || val == "co.uk" || val == "mobi" || val == "co.nz")
                  {
		          costDomain = data.domains[val][0];
			  showPerYearWarning = 1;
                  } else {
                          costDomain = data.domains[val][0];
			  if (!costDomain)
			  {
                          	costDomain = data.domains[val][1];
			  }
		  }
			// for domains that require it, show * and txt differentiating between search result price and cart price
			var extra3 = '';
                        if (showPerYearWarning)
                        {
                                extra3 = '*';
                        }

			var extra1 = '';
                        var extra2 = '';
			var dname = pureDomainName + "." + val;
                        if (searchterm == dname)
                        {
                             extra1 = '<b>';
                             extra2 = '</b>';
                        }

			var fieldname = "result"+ type +"_" + pureDomainName + "." + val + "_price";
                        document.getElementById(fieldname).innerHTML = extra1 + makePrice(costDomain) + extra3 + extra2;
		}
	   
        });
    
	for (var a=0, len3=orderedTLDs.length; val3=orderedTLDs[a], a<len3; a++)
	{
        	var cartlist = oc(oocart.domainList());
                var domain_name = pureDomainName + "." + val3;
		 $.getJSON("/bin/ajax/search" , { domain: domain_name, type: "regular", currency:currency }, function(data){
                        $.each(data.names, function(i,item){
                                if (item.available != "taken") {
                                       totalprice += parseFloat(item.price);
                                        totalavailable.push(item.name);
                                }

                                var fieldname = "result"+ type +"_" + item.name + "_status";

				var extra1 = '';
                		var extra2 = '';
                		if (searchterm == item.name)
                		{
                       	 		extra1 = '<b>';
                        		extra2 = '</b>';
		                }


                                var availStatus;
                                if (item.available == "taken"){
                                        availStatus = " " + extra1 +""+ _("search_js_taken") +""+ extra2 + " ";
                                } else {
					var addToCartStyle = "";
					var inCartStyle = "";
					if (item.name in cartlist){
						addToCartStyle = "style='display:none;'";
                                        } else {
						inCartStyle = "style='display:none;'";
					}
					availStatus = "<a class='addtocart' href='javascript:addToCart(\""+item.name+"\",\""+type+"\",\""+item.price+"\" )'" + addToCartStyle + ">"+extra1+_("search_js_add_tocart")+extra2+"</a><span class='incart'" + inCartStyle + ">" + extra1+_("search_js_incart") +extra2+ "</span>";
                                }

                                if (fieldname)
                                {
                                        document.getElementById(fieldname).innerHTML = availStatus;
                                }
                        });
                });

	}

	if ( totalavailable.length > 0 ){
            $("#" + type + " tfoot").html("<tr><td colspan='3'>&nbsp;</td></tr>");
        }

        var sorting = [[3,1]]; 
        $("#" + type).trigger("update");
        $("#" + type).trigger("sorton",[sorting]); 
}

function setCountryPromo(){
    if (countrycode_ip in oc(['AU','CA','DE','FR','GB','NZ','TV','EU'])){ // show country if we have one
        $("div#promo").html("<img src='/images/ccpromo/"+countrycode_ip+".jpg'>");
    } else if (countrycode_ip in oc(['BE','GB','CZ','DK','DE','EE','IE','GR','ES','FR','IT','CY','LV','LT','LU','HU','MT','NL','AT','PL','PT','RO','SI','SK','FI','SE','GB'])){ // show eu
        $("div#promo").html("<img src='/images/ccpromo/EU.jpg'>");
    } else {  //show tv default
        $("div#promo").html("<img src='/images/ccpromo/TV.jpg'>");
    }
}

function transferDomain(domain){
    var transfer_bubble = new Bubble("tbubble", "ok");
    transfer_bubble.form_id = 'transferform';
    transfer_bubble.form_onsubmit = 'checkAuthCode(this); return false;';

    if (domain) {
        transfer_bubble.body += "<input type='hidden' name='domain' value='"+domain+"'/>";
    }
    transfer_bubble.arbitrarycode = '<div style="position: absolute; top: 15px; left: 15px;"><img src="/images/img_inbox.gif"/></div>'; 


    transfer_bubble.body += "<br/><p style='text-align:left'>"+ _("search_js_transfer_bubble_para1") + "</p><br/>";

    transfer_bubble.body += "<p style='text-align:left'>" + _("search_js_transfer_bubble_para2") + "</p><br/>";
    if (domain){
        track("transfer/b");
        transfer_bubble.body += "<br/><p><input type='checkbox' name='agree'>" + _("search_js_transfer_bubble_confirm1", Array(domain)) + "</p><br/>";
    } else {
        track("transfer/a");
        transfer_bubble.body += "<br/><p><input type='checkbox' name='agree'>" + _("search_js_transfer_bubble_confirm2") + "</p><br/>";
        transfer_bubble.body += "<p style='text-align:right; padding-right:105px'>" + _("search_js_transfer_bubble_domain") + "<input type='text' name='domain'/></p><br/>";
    }
    transfer_bubble.body += "<p  style='text-align:right; padding-right:105px'>" + _("search_js_transfer_bubble_authcode") + "<input type='text' name='authcode'/></p><br/>";
    transfer_bubble.body += "<p><span style='cursor: pointer;' onclick='$.modal.close()'><img src='/images/btn_cancel.png'/></span>&nbsp;&nbsp;&nbsp;&nbsp;<input type='image' src='/images/btn_continue.png' value='Continue'/></p>";
    var html= "";
    if (domain){
        html ="<h2 style='margin: 0pt 0pt 20px; text-align: left; font-size: 2.4em;'>" + _("search_js_transferring") + " <span class='red'>"+domain+"</span></h2>" + transfer_bubble.HTML();
    } else {
        html ="<h2 style='margin: 0pt 0pt 20px; text-align: left; font-size: 2.4em;'>" + _("search_js_transfer") + "</h2>" + transfer_bubble.HTML();
    }

    $.modal(html,{autoResize:[false], autoPosition:[false] });
    //#####################
    $('#transferform').closest("#simplemodal-container").css("top","50px").css("position","absolute");
    $(window).unbind('resize.simplemodal'); // hack to disable simplemodal resizing
    if ($(window).width() >= 940){
        $('#transferform').closest("#simplemodal-container").css("left", (($(window).width() - 760)/2)).css("top","50px");
    } else {
        $('#transferform').closest("#simplemodal-container").css("left", "90px").css("top","50px");
    }
    //####################
}

function checkAuthCode (form) {
//	alert("sending to /bin/ajax/transfer authcode "+form.authcode.value+" for domain: "+form.domain.value);

    if (form.agree.checked == false) { 
        alert(_("search_js_auth_check"));
    } else if (form.domain.value == "") { 
        alert(_("search_js_auth_check_domain"));
    } else if (form.authcode.value == "") { 
        alert(_("search_js_auth_check_code"));
    } else {
        $.getJSON("/bin/ajax/transfer" , { authcode:form.authcode.value  , domain: form.domain.value }, function(data){
            if (data.transfer == 0){ 
		if (data.result == "[Melbourne IT is current registrar]")  
		{
	                alert(_("search_js_transfer_melbourne_existing"));
		} else if (data.result == "[Unable to retrieve domain info]")
                {
                        alert(_("search_js_transfer_domauth_fail"));
                } else if (data.result == "[Transfer request found]")
                {
                        alert(_("search_js_transfer_request_found"));
		} else {
	                alert(data.result+_("search_js_auth_check_code"));
		}
            } else { 
		var safeauthcode = form.authcode.value;
		safeauthcode = safeauthcode.replace(/&/g, "&amp;").replace(/</g,"&lt;").replace(/>/g, "&gt;");
                addToCart(form.domain.value, "transfer", safeauthcode);
                $.modal.close();
                view("cart"); 
                showCart();
            }
        });
    }
}


var heading = "<tr><th class=\"domain\" style='width:400px;'>Domain</th><th class=\"prices\" style='width:100px;'>Price</th><th class=\"status\" style='width:500px;text-align:center;'>Actions</th></tr>";


var maxresults = 12;

String.prototype.toProperCase = function(){
  return this.toLowerCase().replace(/^(.)|\s(.)/g, function($1) { return $1.toUpperCase(); });
}

String.prototype.escapeDots = function(){
    return this.replace(/\./g,"\\.")
}

function searchType(type) {
    var table = $('#' + type);
    table.children('tfoot').html("<tr><td colspan='3'>&nbsp;</td></tr>");
    var count = 0;
    table.children('tbody').html("<tr><td colspan=3 class='waiting'></td></tr>");
    $.getJSON("/bin/ajax/search" , { domain: searchterm, type:type, currency:currency }, function(data){
        table.children('tfoot').html("<tr><td colspan='3'>&nbsp;</td></tr>");
        if (data.results.length == 0){
            table.children('tbody').html("<tr><td colspan=3><h2>" + _("search_js_none_found", Array(_("search_js_"+type))) + "</h2></td></tr>");
            table.trigger("update");
        } else {
            table.children('tbody').html("");
            var cartlist = oc(oocart.domainList());
	     $.each(data.results, function(i,item){
		if(item.name.substring(item.name.length - search_cctld.length,item.name.length) == search_cctld) { return true; }  // Skip ccTLD duplicates.
                table.children('tbody').append("<tr class='search_"+item.name+"'><td>"+item.name+"</td><td style='text-align:left;'>"+ makePrice(roundVal(parseFloat(item.price)))+"</td><td style='text-align:center;' class='actions'><a class='addtocart' href='javascript:addToCart(\""+item.name+"\",\""+type+"\",\""+item.price+"\")'>" + _("search_js_add_tocart") + "</a><span class='incart' style='display:none;'>" + _("search_js_incart") + "</span></td></tr>");

                if (item.name in cartlist){
                    table.children('tbody').children("tr").last().children("td.actions").children(".addtocart").hide();
                    table.children('tbody').children("tr").last().children("td.actions").children(".incart").show();
                }
                
                if ((count >= maxresults) && (data.results.length > (maxresults + 2)  )){ // hide some results for the show more button to unhide unless we are within two results of the full list
                    table.children('tbody').children('tr').last().hide();
                    table.children('tfoot').html("<tr><td colspan='3'><a class=\"bold\" href='javascript:moreResults(\""+type+"\")'>" + _("search_js_more", Array(_("search_js_"+type))) + "</a></td></tr>");
                } else {
                    table.children('tfoot').html("<tr><td colspan='3'>&nbsp;</td></tr>");
                }

                count++;
                if (item.name == searchterm ){
                    table.children('tbody tr').last().children().addClass("exactmatch");
                }
                makeLinksWork();
            });

            table.children('tbody tr').first().children().addClass("exactmatch").first().append("<span class='smallflag'>&nbsp</span>");
            table.trigger("update");
        }
    });
}

function moreResults(type){
    $("table#" + type + " tbody tr").show();
    $("table#" + type).children('tfoot').html("<tr><td colspan='3'>&nbsp;</td></tr>");
}

