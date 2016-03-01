<section id="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <?php echo heading($article->post_title) ?>
                    <div class="post-meta text-uppercase">
                        <span><?php echo unix_to_human(strtotime($article->post_publish_when), TRUE, 'us') ?></span>
                        <?php
                        if (!empty($article->ptc)) {
                            $ptc = [];
                            foreach (array_intersect_key($categories, $article->ptc) as $category)
                                $ptc[] = sprintf('<span>%s</span>', anchor('portalga/article/category/' . $category->category_slug, $category->category_name));

                            echo '<span>In</span>' . implode(', ', $ptc);
                        }
                        ?>
                        <span>By <?php echo $article->create_by ?></span>
                    </div>
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
                        <?php echo $article->post_content ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3">
                <div class="sidebar-widget">
                    <div class="blog-search">
                        <form>
                            <input type="text" name="search">
                            <span>
                                <button id="submit_btn" class="search-submit" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </form>
                    </div>
                </div>
                <div class="sidebar-widget">
                    <?php
                    echo heading('Categories', 4);
                    echo '<ul>';
                    foreach ($categories as $cat => $category)
                        echo sprintf('<li>%s</li>', anchor('portalga/article/category/' . $category->category_slug, $category->category_name));

                    echo '</ul>';
                    ?>
                </div>

                <div class="sidebar-widget">
                    <?php
                    echo heading('Tags', 4);
                    echo '<div class="tagcloud">';
                    foreach ($tags as $t => $tag)
                        echo anchor('portalga/article/tag/' . $tag->tag_slug, $tag->tag_content);

                    echo '</div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>