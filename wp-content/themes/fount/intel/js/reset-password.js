var SCRIPT_PATH = location.protocol + '/wp-content/themes/fount/intel/lib/all.php';

$(document).ready(function () {

    $('#change-pass').click(function (e) {

        $('#change-pass').hide();

        url = SCRIPT_PATH + "?action=resetpassword";
        var email = $('#userEmail').val();
        var newpass = $('#new-pass').val();
        var cnfrmPass = $('#cnfrm-pass').val();

        //define password rules
        var upper_text = new RegExp('[A-Z]');
        var lower_text = new RegExp('[a-z]');
        var number_check = new RegExp('[0-9]');

        //check validation
        var flag = 0;
        if (newpass == '') {
            error = 'Please choose a password.';
            flag++;
        } else if (!newpass.match(upper_text)) {
            error = 'Use at least one upper case letter.';
            flag++;
        } else if (!newpass.match(lower_text)) {
            error = 'Use atleast one lower case letter.';
            flag++;
        } else if (!newpass.match(number_check)) {
            error = 'Use atleast one digit.';
            flag++;
        } else if (newpass.length < 6) {
            error = 'Password must contains 6 letters.';
            flag++;
        } else if (newpass != cnfrmPass) {
            error = 'Password do not match.';
            flag++;
        }
        if (flag > 0) {
            $('.password-error').text(error);
            $('#password-error').css('display', 'block');
            $('#change-pass').show();
            return false;
        }

        $('#password-error').css('display', 'none');
        var data = [{name: 'reset', 'value': email}, {name: 'pass', 'value': newpass}];

        $.post(url, data, function (response) {
            if (response) {
                $('.alert-success').css('display', 'block');
                $('.input-container').css('display', 'none');
            }
        });

    });

    setTimeout(function () {
        $('#new-pass').val('');
    }, 1000);

});

$(document).ready(function () {

    $('#reset').click(function (e) {

        $('.alert-success').hide();
        url = SCRIPT_PATH + "?action=resetpasswordRequest";
        var email = $('#reset-pass').val();
        var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var is_email = re.test(email);

        if (is_email == false) {
            $('#email-error div').html('<strong>Warning!</strong> Please enter valid email address..');
            $('#email-error').show();
            return false;
        }

        $('#email-error').hide();
        var data = {name: 'reset', 'value': email};

        $.post(url, data, function (response) {
            if (response) {
                var res = JSON.parse(response);
                if (res.success) {
                    $('.alert-success').show();
                    $('.reset-pass-btn').addClass('reset-pass-grey-btn').removeClass('reset-pass-btn');
                    $('#reset').prop('disabled',true);
                } else {
                    $('#email-error div').text('This email is not registered at opaxe.');
                    $('#email-error').show();
                }
            }
        });

    });

});


function activateReg(email) {

    url = SCRIPT_PATH + "?action=activateReg";
    var data = {
        email: email
    };

    $.post(url, data, function (response) {
        if (response) {
            var res = JSON.parse(response);
            var urlforPref = 'https://rscmme.us5.list-manage.com/profile/?u=2ccf06e2022ac43c8d1935fa5&id=7a7174148c&e=' + res.key + '';
            $('#templateContainer').css('display', 'block');
            $('#manage-pref').attr("href", urlforPref);
        }
    });

}


function onSuccessfulReg() {

    url = SCRIPT_PATH + "?action=subUser";
    var data = JSON.parse(sessionStorage.getItem("newRegUser"));

    if (data) {
        $('#templateContainer').show();
        $.post(url, data, function (response) {
            if (response) {
                var res = JSON.parse(response);
                sessionStorage.setItem("newRegUser", "");
            }
        });
    } else {
        $('.alert-danger').show();
    }

}
