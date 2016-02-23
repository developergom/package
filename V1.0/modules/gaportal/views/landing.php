<section id="slider">
    <div id="home-carousel" class="carousel slide" data-ride="carousel">			
        <div class="carousel-inner">
            <?php
            foreach ($slider as $index => $row) {
                $thumb = json_decode_db($row['post_featured_img']);
                ?>
                <div class="item <?php echo $index == FALSE ? 'active' : NULL ?>" style="background-image: url(./assets/images/gaportal/post/slider/<?php echo (string) $thumb[0] ?>)">
                    <div class="carousel-caption container">
                        <div class="row">
                            <div class="col-sm-9">
                                <?php
                                echo heading(anchor('portalga/article/' . $row['post_slug'], $row['post_title']));
                                echo heading($row['post_subtitle'], 2);
                                echo sprintf('<p>%s</p>', word_limiter(strip_tags($row['post_content']), 20));
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
            foreach ($general_services as $gs) {
                ?>
                <div class="col-md-4 col-sm-6 st-service">
                    <?php
                    echo heading('<i class="fa fa-info-circle"></i>' . $gs['category_name'], 2);
                    echo sprintf('<p>%s</p>', $gs['category_description']);
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
                        foreach ($procurement['category'] as $pcat) {
                            echo sprintf('<li><a href="#" data-filter=".%s">%s</a></li>', url_title($pcat), $pcat);
                        }
                        ?>
                    </ul>
                </div>

                <div class="portfolio-items">
                    <?php
                    foreach ($procurement['post_to_category'] as $ptc) {
                        $thumb = json_decode_db($ptc['post_featured_img']);
                        ?>
                        <div class="col-md-4 col-sm-6 work-grid <?php echo $ptc['index'] ?>">
                            <div class="portfolio-content">
                                <img class="img-responsive" src="./assets/images/gaportal/post/thumb/<?php echo $thumb[0] ?>" alt="">
                                <div class="portfolio-overlay">
                                    <a href="./assets/images/gaportal/post/thumb/<?php echo $thumb[0] ?>"><i class="fa fa-camera-retro"></i></a>
                                    <?php
                                    echo heading($ptc['post_title'], 5);
                                    echo sprintf('<p>%s</p>', word_limiter(strip_tags($ptc['post_content']), 10));
                                    ?>
                                </div>
                            </div>	
                        </div>
                        <?php
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
                    echo heading($engineering['category']['category_name'], 4);
                    echo sprintf('<p>%s</p>', $engineering['category']['category_description']);
                    echo anchor('#', 'View More', 'class="btn btn-send"');
                    ?>
                </div>
            </div>
            <div class="col-sm-6 our-office">
                <div id="office-carousel" class="carousel slide" data-ride="carousel">			
                    <div class="carousel-inner">
                        <?php
                        foreach ($engineering['post_to_category'] as $ieptc => $eptc) {
                            $eactive = $ieptc == FALSE ? 'active' : NULL;
                            $thumb = json_decode_db($eptc['post_featured_img']);
                            ?>
                            <div class="item <?php echo $eactive ?>">
                                <img src="./assets/images/gaportal/post/thumb/<?php echo $thumb[0] ?>" alt="">
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
                $thumb = json_decode_db($sptc['post_featured_img']);
                ?>
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img class="img-responsive" src="./assets/images/gaportal/members/team1.jpg" alt="">
                        </div>
                        <div class="member-info">
                            <?php
                            echo heading(anchor('#', $sptc['post_title']), 4);
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