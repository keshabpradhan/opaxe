<?php get_header(); ?>

    <style type="text/css">

        #reset-div {
            margin: 100px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .input-container {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            width: 100%;
            margin-bottom: 15px;
        }

        .icon {
            padding: 10px;
            background: dodgerblue;
            color: white;
            min-width: 50px;
            text-align: center;
            height: 45px !important;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            outline: none;
        }

        /*.input-field:focus {*/
            /*border: 2px solid dodgerblue;*/
        /*}*/

        /* Set a style for the submit button */
        .btn {
            background-color: dodgerblue;
            color: white;
            padding: 15px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .btn:hover {
            opacity: 1;
        }

        #menu_section {
            display: none;
        }

        #reset-heading {
            margin: 0px 0px 20px 0px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-ui.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-migrate-1.0.0.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/reset-password.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/opaxe.css"/>
    <body>

    <?php
    $url = get_query_var('reset-pass-param');
    $decoded_string = explode("&",base64_decode($url));
    $email = $decoded_string[0];
    $isResetFromEmail = $decoded_string[2];
    $isValid = true;
    if($isResetFromEmail == 'false') {
        $current_time = new DateTime($decoded_string[1]);
        $passed_time = new DateTime(date('Y-m-d h:i:sa'));
        $interval = $passed_time->diff($current_time);
        $diff = $interval->format("%h%");
        if($diff > 10) {
            $isValid = false;
        }
    }
    if (!$isValid){
        ?>
        <div style="margin: 238px">
            <div class="alert alert-danger">
                <strong>Admin Info!</strong> Your password confirmation link expired.
            </div>
        </div>
    <?php } else{ ?>
    <div id="reset-div">
        <h2 id="reset-heading">Set New password</h2>
        <div style="max-width:500px;">
            <div class="input-container" style="display: none;">
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="text" value="<?php echo $email; ?>" name="userEmail" id="userEmail"
                       required>
            </div>
            <div class="input-container">
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="password" placeholder="Enter new password" value="" name="new-pass"
                       id="new-pass" autocomplete="off">
            </div>
            <div class="input-container">
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="password" placeholder="Confirm new password" value="" name="cnfrm-pass"
                       id="cnfrm-pass" autocomplete="off">
            </div>
            <button type="submit" id="change-pass" class="btn">Change Password</button>
            <a href="/" class="back-to-opaxe-link">Back to opaxe</a>
        </div>
        <div class="alert alert-success" style="display: none;margin-top: 50px;width:700px">
            You have successfully updated your password.
        </div>
        <div style="display: none;margin:42px 0px 0px 0px;width:502px" id="password-error">
            <div class="alert alert-danger">
                <strong>Warning!</strong> <span class="password-error"></span></div>
        </div>
    </div>
    </body>
<?php } ?>