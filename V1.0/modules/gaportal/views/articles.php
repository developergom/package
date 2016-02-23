<section id="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h1>&nbsp;</h1>
                    <span class="st-border"></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-11">
                        <?php
                        foreach ($articles as $article) {
                            ?>
                            <div class="single-blog">
                                <article>
                                    <?php
                                    $post_featured_img = json_decode_db($article->post_featured_img);
                                    if (count($post_featured_img) > 1) {
                                        ?>
                                        <div class="post-slider">
                                            <div id="post-carousel" class="carousel slide" data-ride="carousel">			
                                                <div class="carousel-inner">
                                                    <?php
                                                    foreach ($post_featured_img as $i => $banner) {
                                                        $active = $i == FALSE ? 'active' : NULL;
                                                        echo '<div class="item ' . $active . '">';
                                                        echo img('./assets/images/gaportal/post/thumb/' . $banner) . '</div>';
                                                    }
                                                    ?>
                                                </div>
                                                <a class="post-carousel-left" href="#post-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                                <a class="post-carousel-right" href="#post-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                                            </div>		
                                        </div> 
                                        <?php
                                    } else {
                                        if (!empty($post_featured_img))
                                            $post_featured_img = reset($post_featured_img);
                                        ?>
                                        <div class="post-thumb"><?php echo img('./assets/images/gaportal/post/thumb/' . $post_featured_img, FALSE, 'class="img-responsive" alt="' . $article->post_title . '"') ?></div>
                                        <?php
                                    }
                                    ?>
                                    <?php echo heading(anchor('portalga/article/' . $article->post_slug, $article->post_title), 4, ' class="post-title"') ?>
                                    <div class="post-meta text-uppercase">
                                        <span><?php echo unix_to_human(strtotime($article->post_publish_when), TRUE, 'us') ?></span>
                                        <?php
                                        if (!empty($article->ptc)) {
                                            $ptc = [];
                                            foreach (array_intersect_key($categories, $article->ptc) as $category)
                                                $ptc[] = sprintf('<span>%s</span>', anchor('portalga/category/' . $category['category_slug'], $category['category_name']));

                                            echo '<span>In</span>' . implode(', ', $ptc);
                                        }
                                        ?>
                                        <span>By <?php echo $article->create_by ?></span>
                                    </div>
                                    <div class="post-article">
                                        <?php echo word_limiter(strip_tags($article->post_content), 41) ?>
                                    </div>
                                    <?php echo anchor('portalga/article/' . $article->post_slug, 'Read More', 'class="btn btn-readmore"') ?>
                                </article>
                            </div>
                            <hr>
                            <?php
                        }

                        echo isset($pagination) ? $pagination : br();
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="sidebar-widget">
                    <div class="blog-search">
                        <?php
                        echo form_open();
                        echo form_input('search');
                        echo sprintf('<span>%s</span>', form_button(['id' => 'submit_btn', 'class' => 'search-submit', 'type' => 'button', 'content' => '<i class="fa fa-search"></i>']));
                        echo form_close();
                        ?>
                    </div>
                </div>
                <div class="sidebar-widget">
                    <?php
                    echo heading('Categories', 4);
                    echo '<ul>';
                    foreach ($categories as $cat => $category)
                        echo sprintf('<li>%s</li>', anchor('portalga/category/' . $category['category_slug'], $category['category_name']));

                    echo '</ul>';
                    ?>
                </div>

                <div class="sidebar-widget">
                    <?php
                    echo heading('Tags', 4);
                    echo '<div class="tagcloud">';
                    foreach ($tags as $t => $tag)
                        echo anchor('portalga/tag/' . $tag['tag_slug'], $tag['tag_content']);

                    echo '</div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>