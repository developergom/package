<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
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
                                    echo sprintf('<tr class="tr" data-key="%s">', $row->$id);
                                    $title = $row->post_title;
                                    $title .= sprintf('<div class="small action" id="qe-%s">', $row->$id);
                                    $title .= anchor($base . '/update/' . $row->$id, '<i class="fa fa-edit"></i>' . nbs() . 'Edit', 'title="Edit data"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                    $title .= anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete user" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url($base . '/delete/' . $row->$id) . '"');
                                    $title .= '</div>';
                                    
                                    echo sprintf('<td>%s</td>', $title);
                                    echo sprintf('<td>%s</td>', $row->create_by);

                                    if (empty($row->ptc)) {
                                        $ptc = ['-'];
                                    } else {
                                        foreach ($row->ptc as $category)
                                            $ptc[$row->$id][] = $categories[$category->category_id];
                                    }
                                    echo sprintf('<td>%s</td>', implode(', ', $ptc[$row->$id]));

                                    if (empty($row->ptt)) {
                                        $ptt = ['-'];
                                    } else {
                                        foreach ($row->ptt as $tag)
                                            $ptt[$row->$id][] = $tags[$tag->tag_id];
                                    }
                                    echo sprintf('<td>%s</td>', implode(', ', $ptt[$row->$id]));

                                    if (!empty($row->post_publish_when)) {
                                        echo sprintf('<td><span class="text-success">%s</span></td>', 'Published' . br() . time_elapsed($row->post_publish_when));
                                    } else {
                                        echo sprintf('<td>%s</td>', 'Last update' . br() . time_elapsed($row->update_when));
                                    }
                                    unset($row->$id);
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