function buildUserBlock(a) {
    console.log('Sample of buildUserBlock(a):', a);

    var b = $('.user[rel="' + a.id + '"]');
    if (b.length < 1) {
        b = $('.user[rel="prototype"]').clone().attr("rel", a.id);
        b.appendTo("#user-container ul.user-list").fadeIn();
        addUserEvents(b)
    }
    var d = a.first_name + " " + a.last_name;
    $(".user-name", b).text(d);
    $(".user-email", b).text(a.email);
    $('.members li[rel="' + a.id + '"] span').text(d)
}


function showUserEdit(a) {
    console.log('showUserEdit:', a);
    addmemberform.reset();

    //alert("click");
    // # is id
    // . is class
    $('input[id=id]').val(a.id);
    $('input[id=first_name]').val(a.first_name);
    $('input[id=last_name]').val(a.last_name);
    $('input[id=email]').val(a.email);
    $('input[id=phone_number]').val(a.phone_number);

    document.getElementById('addmemberform').getElementsByTagName('h3')[0].innerHTML = 'edit member';

    $('#divfirst_nameerror').hide();
    $('input[id=first_name]').removeClass('error');
    $('#divfirst_name').removeClass('error');
    $('#divlast_nameerror').hide();
    $('input[id=last_name]').removeClass('error');
    $('#divlast_name').removeClass('error');
    $('#divemailerror').hide();
    $('input[id=email]').removeClass('error');
    $('#divemail').removeClass('error');
    $('#divmultipleerror').hide();

    $('button[data-controls-modal=modal-from-dom]').click();
}


function clearAddMemberForm()
 {
    addmemberform.reset();

    $('input[id=id]').val('');
    $('input[id=first_name]').val('');
    $('input[id=last_name]').val('');
    $('input[id=email]').val('');
    $('input[id=phone_number]').val('');

    document.getElementById('addmemberform').getElementsByTagName('h3')[0].innerHTML = 'add member';

    $('#divfirst_nameerror').hide();
    $('input[id=first_name]').removeClass('error');
    $('#divfirst_name').removeClass('error');
    $('#divlast_nameerror').hide();
    $('input[id=last_name]').removeClass('error');
    $('#divlast_name').removeClass('error');
    $('#divemailerror').hide();
    $('input[id=email]').removeClass('error');
    $('#divemail').removeClass('error');
    $('#divmultipleerror').hide();

}

$(document).ready(function() {
    $('#addmemberformsubmit').click(function() {

        console.log('in addmemberformsubmit');

        //Get the data from all the fields
        var id = null;
        if ($('input[id=id]') != null)
        {
            id = $('input[id=id]');
        }

        var first_name = $('input[id=first_name]');
        var divfirst_name = $('div[id=divfirst_name]');
        var last_name = $('input[id=last_name]');
        var divlast_name = $('div[id=divlast_name]');
        var email = $('input[id=email]');
        var divemail = $('div[id=divemail]');
        var phone_number = $('input[name=phone_number]');
        var divphone_number = $('div[id=divphone_number]');
        var is_admin = 0;

        if ($('#is_admin:checked').val() !== undefined) {
            is_admin = "1";
        }

        var failcount = 0;
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (first_name.val() == '') {
            divfirst_name.addClass('error');
            $('#divmultipleerror').fadeIn('slow');
            failcount += 1;
            //          return false;
        } else {
            $('#divmultipleerror').fadeOut('fast');
            divfirst_name.removeClass('error');
        }

        if (last_name.val() == '') {
            divlast_name.addClass('error');
            $('#divmultipleerror').fadeIn('slow');
            failcount += 1;
            //          return false;
        } else {
            $('#divmultipleerror').fadeOut('fast');
            divlast_name.removeClass('error');
        }


        if (email.val() == '') {
            divemail.addClass('error');
            $('#divmultipleerror').fadeIn('slow');
            failcount += 1;
            //          return false;
        } else {
            $('#divmultipleerror').fadeOut('fast');
            divemail.removeClass('error');
        }

        if (!first_name.val() || !last_name.val() || !email.val()) {
            $('#divmultipleerror').fadeIn('slow');
            return false;
        } else {
            $('#divmultipleerror').fadeOut('fast');
        }

        if (failcount > 0)
        {
            $('#divfirst_nameerror').hide();
            $('#divlast_nameerror').hide();
            $('#divemailerror').hide();
            $('#divmultipleerror').fadeIn('slow');
        }

        //organize the data properly
        var data = 'first_name=' + first_name.val() + '&last_name=' + last_name.val() + '&email=' + email.val() + '&phone_number=' + phone_number.val() + '&id=' + id.val();

        //show the loading sign
        //$('.loading').show();
        //$('#addmemberformsubmitbutton').fadeOut('slow');

        $.ajax({
            url: "/accounts/user/save",
            type: "POST",
            data: data,
            cache: false,
            success: function(data) {
                //if process.php returned 1/true (send mail success)
                //$('#divresult').html(data);
                if (console && console.log) {
                    console.log('Sample of data:', data);
                }

                if (data.error)
                {
                    $('#modal-from-dom').show();
                    $('#divmultipleerror').html("<p><strong>Oh snap!</strong> " + data.message + "</p>");
                    $('#divmultipleerror').fadeIn('slow');
                } else {
                    console.log('No error, submitting of data:', data);

                    buildUserBlock(data);
                    $('#modal-from-dom').removeClass('in');
                    $('.modal-backdrop').removeClass('in');
                    $('.modal-backdrop').removeClass('fade');
                    $('.modal-backdrop').hide();
                }

                if (data) {
                    $('#modal-from-dom').removeClass('fade');
                    $('#modal-from-dom').hide();

                    addmemberform.reset();

                    //if process.php returned 0/false (send mail failed)
                } else {
                    alert('Meh, we couldn\'t save the member data. Try refreshing the page!');
                }
                //          return false;
            }
        });

        //cancel the submit button default behaviours
        return false;
    });
});