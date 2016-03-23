<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-6 footer-social-icons">
                <!--span>Follow us:</span>
                <a href=""><i class="fa fa-facebook"></i></a>
                <a href=""><i class="fa fa-twitter"></i></a>
                <a href=""><i class="fa fa-google-plus"></i></a>
                <a href=""><i class="fa fa-pinterest-p"></i></a-->
            </div>
            <div class="col-sm-6 col-sm-pull-6 copyright">
                <p><?php echo '&copy;' . nbs() . date('Y') . nbs() . anchor('/portalga', 'GA Portal') . nbs() . 'All Right Reserved.' ?></p>
            </div>
        </div>
    </div>
</footer>

<div class="scroll-up">
    <ul><li><a href="#header"><i class="fa fa-angle-up"></i></a></li></ul>
</div>

<?php
$js = [
    'jQuery-1.11.1.min',
    'bootstrap.min',
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
foreach ($js as $v)
    echo script_tag('gaportal/' . $v);
?>

</body>
</html>