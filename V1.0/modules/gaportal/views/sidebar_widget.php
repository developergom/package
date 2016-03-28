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
        foreach ($categories as $cat => $category) {
            echo sprintf('<li>%s</li>', anchor('portalga/category/' . $cat, $category));
        }
        echo '</ul>';
        ?>
    </div>

    <div class="sidebar-widget">
        <?php
        echo heading('Tags', 4);
        echo '<div class="tagcloud">';
        foreach ($tags as $t => $tag) {
            echo anchor('portalga/tag/' . $t, $tag);
        }
        echo '</div>';
        ?>
    </div>
</div>
</div>
</div>
</section>

<!-- /BLOG -->