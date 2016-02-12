<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>GA Portal</title>
        <?php
        $css = [
            'owl.carousel',
            'magnific-popup',
            'style',
            'responsive',
        ];

        echo link_tag('asset/css/bootstrap.min.css');
        echo link_tag('asset/css/font-awesome.min.css');
        foreach ($css as $v)
            echo link_tag('asset/css/gaportal/' . $v . '.css');

        if (!empty($style)) {
            if (!is_array($style))
                $style = [$style];

            foreach ($style as $_style)
                echo link_tag('asset/css/gaportal/' . $_style . '.css');
        }
        ?>

        <!-- Favicon -->
        <?php echo link_tag('asset/img/fav.gif', 'shortcut icon') ?>
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/icon/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/icon/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/icon/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="images/icon/apple-touch-icon-57-precomposed.png">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>

        <!-- PRELOADER -->
        <div id="st-preloader">
            <div id="pre-status">
                <div class="preload-placeholder"></div>
            </div>
        </div>
        <!-- /PRELOADER -->

        <!-- HEADER -->
        <header id="header">
            <nav class="navbar st-navbar navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#st-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?php //anchor('gaportal/home', img(base_url('asset/img/gom.png')), 'class="logo"') ?>
                        <a class="logo" href="<?php echo base_url('gaportal/') ?>">
                            <?php echo img(base_url('asset/img/gom.png')) ?>
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="st-navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#header">Home</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#our-works">Works</a></li>
                            <li><a href="#pricing">Pricing</a></li>
                            <li><a href="#our-team">Team</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li><?php echo anchor('gaportal/article', 'Blog') ?></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container -->
            </nav>
        </header>
        <!-- /HEADER -->