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
        /*input:focus, textarea:focus, select:focus {*/
            /*color: #6b6b6b;*/
            /*border-color: #6b6b6b!important;*/
        /*}*/
        .btn:hover {
            opacity: 1;
        }

        #menu_section {
            display: none;
        }

        #reset-heading {
            margin-left: 5px;
            margin-bottom: 5px;
        }
        #reset {
            margin-left: 5px;
        }
        #email-error {
            display: none;
            margin:24px 0 0 5px;
            width: 500px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-ui.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-migrate-1.0.0.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/reset-password.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/opaxe.css"/>
    <body>

    <?php if (!is_user_logged_in()) {
    ?>

    <div id="reset-div">
        <h2 id="reset-heading">Reset Password</h2>
        <div style="max-width:500px">
            <div class="input-container">
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="email" placeholder="Email" name="email" id="reset-pass" required>
            </div>
            <button type="submit" id="reset" class="btn reset-pass-btn">Reset</button>
            <a href="/?login=true" class="back-to-opaxe-link">Back to opaxe</a>
            <div id="email-error">
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please enter valid email address..
                </div>
            </div>
        </div>
        <div class="alert alert-success email-sent-message">
            A confirmation email has been sent to your email address.
            Please check your inbox or spam folder.
        </div>

    </div>
    </body>

<?php } else {

    ?>
    <div style="margin: 238px">
        <div class="alert alert-danger">
            <strong>Admin Info!</strong> Lost Password Form is not showing up when you're logged.
        </div>
    </div>
    </body>
<?php } ?>