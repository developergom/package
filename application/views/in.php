<?php echo doctype() ?>
<html lang="en">
    <head>
        <base href="<?php echo base_url() ?>" />
        <title>Package</title>
        <link rel="shortcut icon" href="#">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php
        $style = array('bootstrap.min', 'AdminLTE.min', 'font-awesome.min', 'bootstrap-validator.min');
        foreach ($style as $css)
            echo link_tag('asset/css/' . $css . '.css');
        ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-box-body">
                <p class="login-box-msg">
                    <?php
                    $key = $this->input->get('error');
                    if (isset($key) && !empty($key)) {
                        switch ($key) {
                            case 'invalid' :
                                echo "<strong>Heads up!</strong> This alert needs your attention, but it's not super important";
                                break;
                            case 'wrong' :
                                echo "<strong>Oh snap!</strong> Change a few things up and try submitting again.";
                                break;
                            case 'blocked' :
                                echo "<strong>Warning!</strong> Better check yourself, you're not looking too good.";
                                break;
                            case 'warning' :
                                echo "<strong>Warning!</strong> Better check yourself, you're not looking too good.";
                                break;
                            default : echo 'Sign in to start your session';
                        }
                    } else {
                        echo 'Sign in to start your session';
                    }
                    ?>
                </p>
                <?php echo form_open('in/come', 'role="form"') ?>
                <div class="form-group has-feedback">
                    <?php echo form_input('key', '', 'placeholder="Username/email" class="form-control" autofocus') ?>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_password('pass', '', 'placeholder="Password" class="form-control"') ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">    
                        <div class="checkbox">
                            <?php echo form_label(form_checkbox('remember_me') . ' Remember me') ?>
                        </div>                        
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
                <?php echo form_close() ?>
                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <?php
                    echo anchor('#', '<i class="fa fa-facebook"></i> Sign in using Facebook', 'class="btn btn-block btn-social btn-facebook btn-flat"');
                    echo anchor('#', '<i class="fa fa-google-plus"></i> Sign in using Google+', 'class="btn btn-block btn-social btn-google btn-flat"');
                    ?>
                </div>
                <?php
                echo anchor('#', 'I forgot my password') . br();
                echo anchor('#', 'Register a new membership', 'class="text-center"');
                ?>
            </div>
        </div>
    </body>
</html>