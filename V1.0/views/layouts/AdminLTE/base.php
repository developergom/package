<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <?php echo heading(anchor($base . '/create/', '<i class="fa fa-plus"></i> Create New'), 3, 'class="box-title"') ?>
                <div class="box-tools pull-right">
                    <?php echo form_open('#', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', '', 'class="form-control pull-right" placeholder="Search..."') ?>
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <?php
                                foreach ($datagrid_header as $k => $head)
                                    echo sprintf('<th aria-name="%s">%s</th>', $k, $head);
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($datagrid)) {
                                foreach ($datagrid as $index => $row) {
                                    echo sprintf('<tr class="tr" data-key="%s">', $row->$id);
                                    $key = array_keys(object_to_array($row));
                                    $row->{$key[1]} = $row->{next($key)};
                                    $row->{$key[1]} .= sprintf('<div class="small action" id="qe-%s">', $row->$id);
                                    $row->{$key[1]} .= anchor($base . '/update/' . $row->$id, '<i class="fa fa-edit"></i>' . nbs() . 'Edit', 'title="Edit data"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                    $row->{$key[1]} .= anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete user" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url($base . '/delete/' . $row->$id) . '"');
                                    $row->{$key[1]} .= '</div>';
                                    unset($row->$id);
                                    foreach ($row as $key => $value)
                                        echo sprintf('<td aria-name="%s">%s</td>', $key, $value);

                                    echo '</tr>';
                                }
                            } else {
                                echo sprintf('<td colspan="%i">Empty data...</td>', count($datagrid_header));
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