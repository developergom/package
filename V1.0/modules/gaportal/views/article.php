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
                            foreach (object_to_array($categories) as $category) {
                                if (in_array($category['category_id'], array_map('array_pop', object_to_array($article->ptc))))
                                    $ptc[] = sprintf('<span>%s</span>', anchor('portalga/article/category/' . $category['category_slug'], $category['category_name']));
                            }

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
                        <?php
                        echo form_open('portalga/article/search/', ['method' => 'GET']);
                        echo form_input('key');
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