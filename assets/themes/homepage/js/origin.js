origin =  $(document).getUrlParam("origin");
if (origin){
    $.cookie("origin",origin, { expires: 3 });
}

