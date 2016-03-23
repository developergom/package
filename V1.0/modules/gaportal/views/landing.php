<section id="slider">
    <div id="home-carousel" class="carousel slide" data-ride="carousel">			
        <div class="carousel-inner">
            <?php
            foreach ($slider as $index => $row) {
                $thumb = !empty($row->post_featured_img) ? json_decode_db($row->post_featured_img) : ['http://placehold.it/1600x600'];
                ?>
                <div class="item <?php echo $index == FALSE ? 'active' : NULL ?>" style="background-image: url(<?php echo $thumb[0] ?>)">
                    <div class="carousel-caption container">
                        <div class="row">
                            <div class="col-sm-9">
                                <?php
                                echo heading(anchor('portalga/article/read/' . $row->post_slug, $row->post_title));
                                echo heading($row->post_subtitle, 2);
                                echo sprintf('<p>%s</p>', word_limiter(strip_tags($row->post_content), 20));
                                ?>
                            </div>
                        </div>
                    </div>					
                </div>
                <?php
            }
            ?>
            <a class="home-carousel-left" href="#home-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
            <a class="home-carousel-right" href="#home-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
        </div>		
    </div>
</section>

<section id="general_service">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <?php echo heading('General Service') ?>
                    <span class="st-border"></span>
                </div>
            </div>

            <?php
            foreach ($general_service as $gs) {
                ?>
                <div class="col-md-4 col-sm-6 st-service">
                    <?php
                    echo heading('<i class="fa fa-info-circle"></i>' . $gs->category_name, 2);
                    echo sprintf('<p>%s</p>', $gs->category_description);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<section id="procurement">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <?php echo heading('Procurement') ?>
                    <span class="st-border"></span>
                </div>
            </div>

            <div class="portfolio-wrapper">
                <div class="col-md-12">
                    <ul class="filter">
                        <li><a class="active" href="#" data-filter="*">All</a></li>	
                        <?php
                        foreach ($procurement['sub'] as $pcat)
                            echo sprintf('<li><a href="#" data-filter=".%s">%s</a></li>', $pcat->category_slug, $pcat->category_name);
                        ?>
                    </ul>
                </div>

                <div class="portfolio-items">
                    <?php
                    foreach ($procurement['post'] as $index => $ptc) {
                        foreach ($ptc as $post) {
                            $thumb = !empty($post->post_featured_img) ? json_decode_db($post->post_featured_img) : ['http://placehold.it/800x600'];
                            ?>
                            <div class="col-md-4 col-sm-6 work-grid <?php echo $index ?>">
                                <div class="portfolio-content">
                                    <?php echo img($thumb[0], TRUE, 'class="img-responsive"') ?>
                                    <div class="portfolio-overlay">
                                        <a href="<?php echo $thumb[0] ?>"><i class="fa fa-camera-retro"></i></a>
                                        <?php
                                        echo heading($post->post_title, 5);
                                        echo sprintf('<p>%s</p>', word_limiter(strip_tags($post->post_content), 10));
                                        ?>
                                    </div>
                                </div>	
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>				
            </div>
        </div>
    </div>
</section>

<section id="engineering">
    <div class="container">
        <div class="col-md-12">
            <div class="section-title">
                <?php echo heading('Engineering') ?>
                <span class="st-border"></span>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="about-us text-center">
                    <?php
                    echo heading($engineering['category']->category_name, 4);
                    echo sprintf('<p>%s</p>', $engineering['category']->category_description);
                    echo anchor('portalga/article/category/' . $engineering['category']->category_slug, 'View More', 'class="btn btn-send"');
                    ?>
                </div>
            </div>
            <div class="col-sm-6 our-office">
                <div id="office-carousel" class="carousel slide" data-ride="carousel">			
                    <div class="carousel-inner">
                        <?php
                        foreach ($engineering['post'] as $ieptc => $eptc) {
                            $eactive = $ieptc == FALSE ? 'active' : NULL;
                            $thumb = !empty($eptc->post_featured_img) ? json_decode_db($eptc->post_featured_img) : ['http://placehold.it/800x530'];
                            ?>
                            <div class="item <?php echo $eactive ?>">
                                <?php echo img($thumb[0]) ?>
                            </div>
                            <?php
                        }
                        ?>
                        <a class="office-carousel-left" href="#office-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                        <a class="office-carousel-right" href="#office-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                    </div>		
                </div>
            </div>
        </div>
    </div>
</section>

<section id="security">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <?php echo heading('Security') ?>
                    <span class="st-border"></span>
                </div>
            </div>
            <?php
            foreach ($security as $sptc) {
                $thumb = !empty($sptc->post_featured_img) ? json_decode_db($sptc->post_featured_img) : ['http://placehold.it/570x675'];
                ?>
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="member-image">
                            <?php echo img($thumb[0], TRUE, 'class="img-responsive"') ?>
                        </div>
                        <div class="member-info">
                            <?php
                            echo heading(anchor('portalga/article/read/' . $sptc->post_slug, $sptc->post_title), 4);
                            //echo sprintf('<span>%s</span>', $post['post_subtitle']);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>