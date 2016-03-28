<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <?php echo heading(anchor('ga/vehicle_rate/create/', '<i class="fa fa-plus"></i> Create New'), 3, 'class="box-title"') ?>
                <div class="box-tools pull-right">
                    <?php echo form_open('#', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', '', 'class="form-control pull-right" placeholder="Search..."') ?>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                                if (!empty($datagrid_header)) {
                                    foreach ($datagrid_header as $head)
                                        echo sprintf('<th aria-name="">%s</th>', $head);
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($datagrid)) {
                                foreach ($datagrid as $index => $row) {

                                    echo sprintf('<tr class="tr" data-key="%s">', $row[$id]);

                                    $vehicle_type = reset($row['type']);
                                    $row['vehicle_type_id'] = $vehicle_type['vehicle_type_brand'] . nbs() . $vehicle_type['vehicle_type_name'] . nbs() . $vehicle_type['vehicle_type_year'];
                                    $row['vehicle_type_id'] .= sprintf('<div class="small action" id="qe-%s">', $row[$id]);
                                    $row['vehicle_type_id'] .= anchor($base . '/update/' . $row[$id], '<i class="fa fa-edit"></i>' . nbs() . 'Edit', 'title="Edit data"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                    $row['vehicle_type_id'] .= anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete user" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url($base . '/delete/' . $row[$id]) . '"');
                                    $row['vehicle_type_id'] .= '</div>';
                                    unset($row[$id]);
                                    unset($row['type']);
                                    foreach ($row as $key => $value)
                                        echo sprintf('<td aria-name="%s">%s</td>', $key, $value);
//
                                    echo '</tr>';
                                }
                            } else {
                                echo sprintf('<td colspan="%i">Empty data...</td>', count($datagrid_header));
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php echo isset($links) ? $links : nbs() ?>
            </div>
        </div>
    </div>    
</div>