<!-- FOOTER -->
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <!-- SOCIAL ICONS -->
                    <div class="col-sm-6 col-sm-push-6 footer-social-icons">
                        <span>Follow us:</span>
                        <a href=""><i class="fa fa-facebook"></i></a>
                        <a href=""><i class="fa fa-twitter"></i></a>
                        <a href=""><i class="fa fa-google-plus"></i></a>
                        <a href=""><i class="fa fa-pinterest-p"></i></a>
                    </div>
                    <!-- /SOCIAL ICONS -->
                    <div class="col-sm-6 col-sm-pull-6 copyright">
                        <p>&copy; 2015 <a href="">ShapedTheme</a>. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /FOOTER -->


        <!-- Scroll-up -->
        <div class="scroll-up">
            <ul><li><a href="#header"><i class="fa fa-angle-up"></i></a></li></ul>
        </div>

        <?php
        $js = [
            'jquery.parallax', 
            'smoothscroll', 
            'masonry.pkgd.min', 
            'jquery.fitvids', 
            'owl.carousel.min', 
            'jquery.counterup.min', 
            'waypoints.min', 
            'jquery.isotope.min', 
            'jquery.magnific-popup.min', 
            'scripts', 
        ];
        
        echo script_tag('jQuery-2.2.0.min');
        echo script_tag('bootstrap.min');
        foreach ($js as $v)
            echo script_tag('gaportal/' . $v);
                
        if(!empty($script)) {
            if(!is_array($script)) 
                $script = array($script);

            foreach($script as $_script)
                echo script_tag($_script);                
        }
        ?>

    </body>
</html>