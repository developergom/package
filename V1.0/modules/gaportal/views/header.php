<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>GA Portal</title>
        <?php
        echo meta('keyword', $meta);
        echo link_tag(STYLE_PATH . 'bootstrap.min.css');
        echo link_tag(STYLE_PATH . 'font-awesome.min.css');
        $css = [
            'owl.carousel',
            'magnific-popup',
            'responsive',
            'style',
            'article',
        ];
        foreach ($css as $v)
            echo link_tag(STYLE_PATH . 'gaportal/' . $v . '.css');
        ?>

        <!-- Favicon -->
        <?php echo link_tag('assets/images/fav.gif', 'shortcut icon') ?>
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
        <div id="st-preloader">
            <div id="pre-status">
                <div class="preload-placeholder"></div>
            </div>
        </div>

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
                        <?php echo anchor('portalga/', img(IMAGE_PATH . 'gom.png'), 'class="logo"') ?>
                    </div>

                    <div class="collapse navbar-collapse" id="st-navbar-collapse">
                        <?php echo ul($menu, 'class="nav navbar-nav navbar-right"') ?>
                    </div>
                </div>
            </nav>
        </header>
