<?php echo doctype('html5') ?>
<html lang="en">
    <head>
        <base href="<?php echo base_url() ?>" />
        <title><?php //echo $app_name . ' :: ' . $title ?></title>
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
            'datepicker3',
            'daterangepicker-bs3',
            'bootstrap3-wysihtml5.min'
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
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b><?php //echo substr($app_name, 0, 3); ?></b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><?php //echo $app_name; ?></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <?php
                                        $notif = array(
                                            anchor('#', '<i class="fa fa-users text-aqua"></i> 5 new members joined today'),
                                            anchor('#', '<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems'),
                                            anchor('#', '<i class="fa fa-users text-red"></i> 5 new members joined'),
                                            anchor('#', '<i class="fa fa-shopping-cart text-green"></i> 25 sales made'),
                                            anchor('#', '<i class="fa fa-user text-red"></i> You changed your username')
                                        );
                                        echo ul($notif, 'class="menu"');
                                        ?>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="asset/img/avatar/<?php echo $this->session->userdata('uava'); ?>" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?php echo $this->session->userdata('nick') ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="asset/img/avatar/<?php echo $this->session->userdata('uava'); ?>" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo '<strong>' . $this->session->userdata('username') . '</strong><br/>' . $this->session->userdata('name') ?>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-12 text-center">
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <?php echo anchor('profile/index/' . $this->session->userdata('user'), '<i class="fa fa-user"></i> Profile', 'class="btn btn-default btn-flat"') ?>
                                        </div>
                                        <div class="pull-right">
                                            <?php echo anchor('sign/out/', '<i class="fa fa-sign-out"></i> Sign out', 'class="btn btn-default btn-flat"') ?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="asset/img/avatar/<?php echo $this->session->userdata('uava'); ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata('name') . ' <small>(' . $this->session->userdata('nick') . ')</small>' ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <!-- form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form -->
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">THE NAVIGATION</li>
                        <li><?php echo anchor('home/', '<i class="fa fa-home"></i> <span>Home</span>') ?></li>
                        <?php //echo $this->sso->menu ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <?php
                    //echo heading($content_header, 1);
                    //echo ol($breadcrumb, 'class="breadcrumb"');
                    ?>
                </section>
                <section class="content">