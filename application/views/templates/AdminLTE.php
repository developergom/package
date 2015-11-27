<?php echo doctype('html5') ?>
<html lang="en">
    <head>
        <base href="<?php echo base_url() ?>" />
        <title><?php echo $app_name . ' :: ' . $title ?></title>
        <link rel="shortcut icon" href="#">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php
        $css = [
            'bootstrap.min',
            'bootstrap-validator.min',
            'font-awesome.min',
            'AdminLTE.min',
            'skins/_all-skins.min',
            //'morris',
            'bootstrap3-wysihtml5.min',
            'initialize'
        ];
        foreach ($css as $v)
            echo link_tag('asset/css/' . $v . '.css');

        if (!empty($style)) {
            if (!is_array($style))
                $style = [$style];

            foreach ($style as $_style)
                echo link_tag('asset/css/' . $_style . '.css');
        }
        ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="#" class="logo">
                    <span class="logo-mini"><b><?php echo substr($app_name, 0, 3); ?></b></span>
                    <span class="logo-lg"><?php echo $app_name; ?></span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <?php
                                        $notif = [
                                            anchor('#', '<i class="fa fa-users text-aqua"></i> 5 new members joined today'),
                                            anchor('#', '<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems'),
                                            anchor('#', '<i class="fa fa-users text-red"></i> 5 new members joined'),
                                            anchor('#', '<i class="fa fa-shopping-cart text-green"></i> 25 sales made'),
                                            anchor('#', '<i class="fa fa-user text-red"></i> You changed your username')
                                        ];
                                        echo ul($notif, 'class="menu"');
                                        ?>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="asset/img/avatar/<?php echo $this->session->userdata('uava'); ?>" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?php echo $this->session->userdata('nick') ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="asset/img/avatar/<?php echo $this->session->userdata('uava'); ?>" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo '<strong>' . $this->session->userdata('username') . '</strong><br/>' . $this->session->userdata('name') ?>
                                        </p>
                                    </li>
                                    <li class="user-body">
                                        <div class="col-xs-12 text-center">
                                        </div>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <?php echo anchor('profile/index/' . $this->session->userdata('user'), '<i class="fa fa-user"></i> Profile', 'class="btn btn-default btn-flat"') ?>
                                        </div>
                                        <div class="pull-right">
                                            <?php echo anchor('in/out/', '<i class="fa fa-sign-out"></i> Sign out', 'class="btn btn-default btn-flat"') ?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="asset/img/avatar/<?php echo $this->session->userdata('uava'); ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata('name') . ' <small>(' . $this->session->userdata('nick') . ')</small>' ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="header">THE NAVIGATION</li>
                        <li><?php echo anchor('/', '<i class="fa fa-home"></i> <span>Home</span>') ?></li>
                        <?php echo $this->sso->menu ?>
                    </ul>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <?php
                    echo heading($content_header, 1);
                    echo ol($breadcrumb, 'class="breadcrumb"');
                    ?>
                </section>
                <section class="content">
                    <?php echo $body ?>
                </section>
            </div>
            <footer class="main-footer">
                <strong>Copyright &copy; <?php echo date('Y') ?></strong> All rights reserved.
            </footer>
        </div>
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <span class="fa fa-warning"></span>
                        <strong> Are you sure want to delete this data ?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-danger danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $js = [
            'jQuery-2.1.4.min',
            'jquery-ui.min',
            'bootstrap.min',
            'bootstrap-validator.min',
            //'raphael-2.1.0.min',
            //'morris.min',
            //'jquery.sparkline.min',
            //'jquery.knob',
            'daterangepicker',
            'bootstrap-datepicker',
            'bootstrap3-wysihtml5.all.min',
            'jquery.slimscroll.min',
            //'fastclick.min',
            //'demo',
            'app.min',
            'initialize'
        ];
        foreach ($js as $v)
            echo script_tag($v);

        if (!empty($script)) {
            if (!is_array($script))
                $script = array($script);

            foreach ($script as $_script)
                echo script_tag($_script);
        }
        ?>
    </body>
</html>