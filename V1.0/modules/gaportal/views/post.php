<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php echo heading(anchor($base . '/create/', '<i class="fa fa-plus"></i> Create New'), 3, 'class="box-title"') ?>
                <div class="box-tools pull-right">
                    <?php echo form_open('#', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', '', 'class="form-control pull-right" placeholder="Search..."') ?>
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <?php
                            $header = ['post_title' => 'Title', 'author' => 'Author', 'category' => 'Categories', 'tag' => 'Tags', 'post_publish_when' => 'Date'];
                            foreach ($header as $k => $head)
                                echo sprintf('<th aria-name="%s">%s</th>', $k, $head);
                            ?>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($datagrid)) {
                                foreach ($datagrid as $index => $row) {
                                    echo sprintf('<tr class="tr" data-key="%s">', $row->post_id);
                                    $title = $row->post_title;
                                    $title .= $row->post_status == 'draft' ? '<span class="text-muted">&nbsp; &HorizontalLine; &nbsp;Draft</span>' : NULL;
                                    $title .= sprintf('<div class="small action" id="qe-%s">', $row->post_id);
                                    $title .= anchor($base . '/update/' . $row->post_id, '<i class="fa fa-edit"></i>' . nbs() . 'Edit', 'title="Edit data"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                    $title .= anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete user" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url($base . '/delete/' . $row->post_id) . '"');
                                    $title .= '</div>';

                                    echo sprintf('<td>%s</td>', $title);
                                    echo sprintf('<td>%s</td>', $row->create_by);

                                    if (empty($row->ptc)) {
                                        $ptc = [$row->post_id => ['-']];
                                    } else {
                                        foreach ($row->ptc as $category)
                                            $ptc[$row->post_id][] = $categories[$category->category_id];
                                    }

                                    echo sprintf('<td>%s</td>', implode(', ', $ptc[$row->post_id]));

                                    if (empty($row->ptt)) {
                                        $ptt = [$row->post_id => ['-']];
                                    } else {
                                        foreach ($row->ptt as $tag)
                                            $ptt[$row->post_id][] = $tags[$tag->tag_id];
                                    }

                                    echo sprintf('<td>%s</td>', implode(', ', $ptt[$row->post_id]));

                                    if (!empty($row->post_publish_when)) {
                                        echo sprintf('<td><span class="text-success">%s</span></td>', 'Published' . br() . time_elapsed($row->post_publish_when));
                                    } else {
                                        echo sprintf('<td>%s</td>', 'Last update' . br() . time_elapsed($row->update_when));
                                    }
                                    unset($row->post_id);
                                    echo '</tr>';
                                }
                            } else {
                                echo sprintf('<td colspan="%i">Empty data...</td>', count($header));
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php echo (isset($links)) ? $links : nbs() ?>
            </div>
        </div>
    </div>    
</div>