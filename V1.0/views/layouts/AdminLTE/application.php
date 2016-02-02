<?php echo doctype('html5'); ?>
<html lang="en">
    <head>
        <base href="<?php echo base_url() ?>" />
        <title><?php echo 'Package | ' . humanize($title) ?></title>
        <?php echo link_tag('asset/img/fav.gif', 'shortcut icon') ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php
        $css = [
            'bootstrap.min',
            'select2.min',
            'bootstrap-validator.min',
            'font-awesome.min',
            'AdminLTE.min',
            'skins/_all-skins.min',
            'iCheck/all'
                //'morris',
                //'datepicker3',
                //'daterangepicker-bs3',
                //'bootstrap3-wysihtml5.min',
        ];
        foreach ($css as $v)
            echo link_tag('asset/css/' . $v . '.css');

        if (!empty($style)) {
            if (!is_array($style))
                $style = [$style];

            foreach ($style as $_style)
                echo link_tag('asset/css/' . $_style . '.css');
        }

        echo link_tag('asset/css/initialize.css');
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
                    <span class="logo-mini"><strong><?php echo substr('Package', 0, 3); ?></strong></span>
                    <span class="logo-lg"><?php echo 'Package' ?></span>
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
                                    <img src="asset/img/avatar/<?php //echo $this->session->userdata('uava');                   ?>" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?php //echo $this->session->userdata('nick')                   ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="asset/img/avatar/<?php //echo $this->session->userdata('uava');                   ?>" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php //echo '<strong>' . $this->session->userdata('username') . '</strong><br/>' . $this->session->userdata('name') ?>
                                        </p>
                                    </li>
                                    <li class="user-body">
                                        <div class="col-xs-12 text-center">
                                        </div>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <?php //echo anchor('profile/index/' . $this->session->userdata('user'), '<i class="fa fa-user"></i> Profile', 'class="btn btn-default btn-flat"') ?>
                                        </div>
                                        <div class="pull-right">
                                            <?php //echo anchor('out/', '<i class="fa fa-sign-out"></i> Sign out', 'class="btn btn-default btn-flat"') ?>
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
                            <img src="asset/img/avatar/<?php //echo $this->session->userdata('uava');                   ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php //echo $this->session->userdata('name') . ' <small>(' . $this->session->userdata('nick') . ')</small>'                   ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="header">THE NAVIGATION</li>
                        <li><?php echo anchor('/', '<i class="fa fa-home"></i> <span>Home</span>') ?></li>
                        <?php //echo $this->sso->menu ?>
                    </ul>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <?php
                    echo heading(anchor($base, humanize($title)), 1);
                    echo ol($breadcrumb, 'class="breadcrumb"');
                    ?>
                </section>
                <section class="content">
                    <?php
                    echo $yield;
                    echo isset($asides) ? $asides : nbs();
                    ?>
                </section>
            </div>
            <footer class="main-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo ENVIRONMENT == 'development' ? '<em>Page rendered in <strong>{elapsed_time}</strong> seconds. </em>' : sprintf('Copyright &copy; %s</strong> All rights reserved.', date('Y')) ?>
                    </div>
                    <div class="col-sm-6">
                        <em class="pull-right"><?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : nbs() ?></em>
                    </div>
                </div>
            </footer>
        </div>
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <i class="fa fa-warning fa-3x pull-left"></i>
                        <strong> Are you sure want to delete this data ?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-danger delete">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $js = [
            'jQuery-2.2.0.min',
            'jquery-ui.min',
            'bootstrap.min',
            'bootstrap-validator.min',
            //'bootstrap-datepicker',
            //'raphael-2.1.0.min',
            //'morris.min',
            //'jquery.sparkline.min',
            //'jquery.knob',
            'icheck.min',
            'select2.min',
            //'bootstrap3-wysihtml5.all.min',
            //'jquery.inputmask.extensions',
            //'jquery.inputmask.date.extensions',
            'jquery.slimscroll.min',
            'fastclick.min',
            //'demo',
            'app.min'
        ];
        foreach ($js as $v)
            echo script_tag($v);

        if (!empty($script)) {
            if (!is_array($script))
                $script = [$script];

            foreach ($script as $_script)
                echo script_tag($_script);
        }

        echo script_tag('initialize');
        ?>
    </body>
</html>