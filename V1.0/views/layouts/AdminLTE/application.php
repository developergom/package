<?php echo doctype('html5'); ?>
<html lang="en">
    <head>
        <base href="<?php echo base_url() ?>" />
        <title><?php echo APP_NAME . ' | ' . $title ?></title>
        <?php echo link_tag('assets/images/fav.gif', 'shortcut icon') ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php
        $css = [
            'bootstrap.min',
            'select2.min',
//            'select2-bootstrap.min',
            'bootstrap-validator.min',
            'font-awesome.min',
            'AdminLTE.min',
            'skins/_all-skins.min',
            'iCheck/all',
//            'morris',
//            'datepicker3',
//            'daterangepicker-bs3',
//            'bootstrap3-wysihtml5.min',
        ];

        foreach ($css as $v)
            echo link_tag(STYLE_PATH . $v . '.css');

        if (!empty($style)) {
            if (!is_array($style))
                $style = [$style];

            foreach ($style as $_style)
                echo link_tag(STYLE_PATH . $_style . '.css');
        }


        echo link_tag(STYLE_PATH . 'initialize.css');
        ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue sidebar-mini sidebar-collapse">
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
        <div class="wrapper">
            <header class="main-header">
                <a href="#" class="logo">
                    <span class="logo-mini"><strong><?php echo substr(APP_NAME, 0, 3) ?></strong></span>
                    <span class="logo-lg"><?php echo APP_NAME; ?></span>
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
                                    <?php echo img(IMAGE_PATH . 'avatar/' . $this->session->userdata('avatar'), TRUE, 'class="user-image" alt="User Image"') ?>
                                    <span class="hidden-xs"><?php echo $this->session->userdata('firstname') . nbs() . $this->session->userdata('lastname') ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <?php echo img(IMAGE_PATH . 'avatar/' . $this->session->userdata('avatar'), TRUE, 'class="img-circle" alt="User Image"') ?>
                                        <p>
                                            <?php echo $this->session->userdata('firstname') . nbs() . $this->session->userdata('lastname') ?> - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <?php echo anchor('sign/out', '<i class="fa fa-sign-out"></i> Sign out', 'class="btn btn-default btn-flat"') ?>
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
                            <img src="assets/images/avatar/<?php echo $this->session->userdata('avatar') ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname'); ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="header">THE NAVIGATION</li>
                        <li><?php //echo anchor('/', '<i class="fa fa-home"></i> <span>Home</span>')  ?></li>
                        <?php echo $this->sso_new->menu ?>
                    </ul>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <?php
                    echo heading(anchor($base, $title), 1);
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

        <script type="text/javascript">
            var base_url = window.location.protocol + '//' + window.location.host + '/package/';
            //var base_url = window.location.protocol + '//' + window.location.host + '/';

            var AdminLTEOptions = {
                //Add slimscroll to navbar menus
                //This requires you to load the slimscroll plugin
                //in every page before app.js
                navbarMenuSlimscroll: true,
                navbarMenuSlimscrollWidth: "3px", //The width of the scroll bar
                navbarMenuHeight: "200px", //The height of the inner menu
                //General animation speed for JS animated elements such as box collapse/expand and
                //sidebar treeview slide up/down. This options accepts an integer as milliseconds,
                //'fast', 'normal', or 'slow'
                animationSpeed: 500,
                //Sidebar push menu toggle button selector
                sidebarToggleSelector: "[data-toggle='offcanvas']",
                //Activate sidebar push menu
                sidebarPushMenu: true,
                //Activate sidebar slimscroll if the fixed layout is set (requires SlimScroll Plugin)
                sidebarSlimScroll: true,
                //Enable sidebar expand on hover effect for sidebar mini
                //This option is forced to true if both the fixed layout and sidebar mini
                //are used together
                sidebarExpandOnHover: false,
                //BoxRefresh Plugin
                enableBoxRefresh: true,
                //Bootstrap.js tooltip
                enableBSToppltip: true,
                BSTooltipSelector: "[data-toggle='tooltip']",
                //Enable Fast Click. Fastclick.js creates a more
                //native touch experience with touch devices. If you
                //choose to enable the plugin, make sure you load the script
                //before AdminLTE's app.js
                enableFastclick: true,
                //Control Sidebar Options
                enableControlSidebar: true,
                controlSidebarOptions: {
                    //Which button should trigger the open/close event
                    toggleBtnSelector: "[data-toggle='control-sidebar']",
                    //The sidebar selector
                    selector: ".control-sidebar",
                    //Enable slide over content
                    slide: true
                },
                //Box Widget Plugin. Enable this plugin
                //to allow boxes to be collapsed and/or removed
                enableBoxWidget: true,
                //Box Widget plugin options
                boxWidgetOptions: {
                    boxWidgetIcons: {
                        //Collapse icon
                        collapse: 'fa-minus',
                        //Open icon
                        open: 'fa-plus',
                        //Remove icon
                        remove: 'fa-times'
                    },
                    boxWidgetSelectors: {
                        //Remove button selector
                        remove: '[data-widget="remove"]',
                        //Collapse button selector
                        collapse: '[data-widget="collapse"]'
                    }
                },
                //Direct Chat plugin options
                directChat: {
                    //Enable direct chat by default
                    enable: true,
                    //The button to open and close the chat contacts pane
                    contactToggleSelector: '[data-widget="chat-pane-toggle"]'
                },
                //Define the set of colors to use globally around the website
                colors: {
                    lightBlue: "#3c8dbc",
                    red: "#f56954",
                    green: "#00a65a",
                    aqua: "#00c0ef",
                    yellow: "#f39c12",
                    blue: "#0073b7",
                    navy: "#001F3F",
                    teal: "#39CCCC",
                    olive: "#3D9970",
                    lime: "#01FF70",
                    orange: "#FF851B",
                    fuchsia: "#F012BE",
                    purple: "#8E24AA",
                    maroon: "#D81B60",
                    black: "#222222",
                    gray: "#d2d6de"
                },
                //The standard screen sizes that bootstrap uses.
                //If you change these in the variables.less file, change
                //them here too.
                screenSizes: {
                    xs: 480,
                    sm: 768,
                    md: 992,
                    lg: 1200
                }
            };
            
            var allowedUploadFiletype = [
                'text/plain',
                'image/jpeg', 'image/png', 'image/gif', 
                'application/pdf', 
                'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                'application/powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/x-rar', 'application/x-gzip', 'application/x-zip'
            ];
        </script>
        <?php
        $js = [
            'jQuery-2.2.0.min',
            'jquery-ui.min',
            'ajaxFileUpload',
            'bootstrap.min',
            'bootstrap-validator.min',
            'bootstrap-filestyle.min',
            'humanize.min',
            'moment.min',
            //'bootstrap-datepicker',
            //'raphael-2.1.0.min',
            //'morris.min',
            //'jquery.sparkline.min',
            //'jquery.knob',
            'icheck.min',
            'select2.full.min',
            //'jquery.inputmask.extensions',
            //'jquery.inputmask.date.extensions',
            'jquery.slimscroll.min',
            'jquery.filedrop.min',
            //'fastclick.min',
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