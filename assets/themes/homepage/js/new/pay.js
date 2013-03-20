//dev testing
Stripe.setPublishableKey('pk_8WfgWTYn3yxf1XvsIByNHApx3mGjh');

function addInputNames() {
    // Not ideal, but jQuery's validate plugin requires fields to have names
    // so we add them at the last possible minute, in case any javascript
    // exceptions have caused other parts of the script to fail.
    $(".card-number").attr("name", "card-number")
    $(".card-cvc").attr("name", "card-cvc")
    $(".card-expiry-year").attr("name", "card-expiry-year")
}

function removeInputNames() {
    $(".card-number").removeAttr("name")
    $(".card-cvc").removeAttr("name")
    $(".card-expiry-year").removeAttr("name")
}

function submitstripe(form) {
    // remove the input field names for security
    // we do this *before* anything else which might throw an exception
    removeInputNames();
    // THIS IS IMPORTANT!
    // given a valid form, submit the payment details to stripe
    //$(form['submit-button']).attr("disabled", "disabled")
    Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val(),
        address_line1: $('.address-line1').val(),
        address_zip: $('.address-zip').val()
    },
    100,
    function(status, response) {
        $(".payment-errors").html(response);

        console.log(status, response);

        if (response.error) {
            // re-enable the submit button
            //$(form['submit-button']).removeAttr("disabled")
            // show the error
            $(".payment-errors").html(response.error.message);

            // we add these names back in so we can revalidate properly
            addInputNames();
        } else {
            // token contains id, last4, and card type
            var token = response['id'];

            // insert the stripe token
            //var input = $("<input name='stripeToken' value='" + token + "' style='display:none;' />");
            //form.appendChild(input[0]);
            //$(".payment-errors").html(token);
            //alert(reponse);
            var amount = response['amount'];
            var id = response['id'];
            var custname = $('#name').val();
            var mode = response['livemode']
            var posttoken = "id=" + id + "&amount=" + amount + "&livemode=" + mode + "&name=" + custname;
            //https://athena.igrou.ps
            console.log("success");

            $.get('/charge/savecustfromtoken?' + posttoken,
            function(data) {
                alert(data.result);
                console.log(data.result);
                $(".payment-errors").html(data.result);
            });
            console.log("success");

            // and submit
            //form.submit();
        }
    });

    return false;
}

function dovalidate(paymentid) {
	if (paymentid == 0) {
		console.log("payment via new card");
	    // add custom rules for credit card validating
	    jQuery.validator.addMethod("cardNumber", Stripe.validateCardNumber, "Please enter a valid card number");
	    jQuery.validator.addMethod("cardCVC", Stripe.validateCVC, "Please enter a valid security code");
	    jQuery.validator.addMethod("cardExpiry",
	    function() {
	        return Stripe.validateExpiry($(".card-expiry-month").val(), $(".card-expiry-year").val())
	    },
	    "Please enter a valid expiration");

	    // We use the jQuery validate plugin to validate required params on submit
	    jQuery("#example-form").validate({
	        errorClass: "error",
	        submitHandler: submitstripe,
	        rules: {
	            "card-cvc": {
	                cardCVC: true,
	                required: true
	            },
	            "card-number": {
	                cardNumber: true,
	                required: true
	            },
	            "address-line1": {
	                required: true
	            },
	            "address-zip": {
	                required: true
	            },
	            "card-expiry-year": "cardExpiry"
	            // we don't validate month separately
	        }
	    });

	    // adding the input field names is the last step, in case an earlier step errors
	    addInputNames();
	
	    console.log("finished");
	} else if (paymentid == 1) {
		console.log("payment via existing card");

		var posttoken = "customerID="+paymentcusid+"&amount="+paymentamount+"";

        $.get('/charge/processCustTokenAmount?' + posttoken,
        function(data) {
            alert(data.result);
            console.log(data.result);
            $(".payment-errors").html(data.result);
        });
        console.log("finished");
	}
}

