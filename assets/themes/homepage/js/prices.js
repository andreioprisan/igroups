var all_prices = null;
function getPrices(){
    if (all_prices == null){
        var response = $.ajax({ url: "/bin/ajax/prices",
                                    async: false, 
                                    data:  { currency:currency },  
                                    dataType: "json" }).responseText ;
        var data = eval('(' + response + ')');
        all_prices = data;
    }
    return all_prices;
}

getPrices();

function getTld(domain){
    var domainarr = domain.split(".");
    domainarr.shift();
    var tld = domainarr.join(".");
    return tld;
}

function getAddonPrice(addon){
    getPrices();
    switch(addon){
        case "privacy": return all_prices.addons[addon][0]; break;
        case "sitelock": return all_prices.addons[addon].lv1[0]; break;
    }
}

function makePrice(value){
    switch(currency){
 	    case "USA": return "$" + value; break;
            case "AU": return "$" + value; break;
            case "NZ": return "$" + value; break;
 	    case "UK": return "&pound;" + value; break;
    }
}
