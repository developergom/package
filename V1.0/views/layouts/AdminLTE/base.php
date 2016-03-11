<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php 
                if(in_array('c',$this->sso_new->curr_access))
                    echo heading(anchor($base . '/create/', '<i class="fa fa-plus"></i> Create New'), 3, 'class="box-title"') 
                ?>
                <div class="box-tools pull-right">
                    <?php echo form_open('#', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', '', 'class="form-control pull-right" placeholder="Search..."') ?>
                        <span class="fa fa-search form-control-feedback"></span>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <?php
                        $message = $this->input->get('message');
                        $status = $this->input->get('status');
                        if (isset($message) && isset($status)) {
                            $alert = $status == 'success' ? 'success' : 'warning';
                            $icon = $status == 'success' ? 'fa-check' : 'fa-exclamation';
                            switch ($message) {
                                case 'insert';
                                    break;
                                case 'update';
                                    break;
                                case 'delete';
                                    break;
                            }
                            ?>
                            <div class="clearfix">&nbsp;</div>
                            <div class="alert alert-<?php echo $alert ?> alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa <?php echo $icon ?>"></i> <?php echo humanize($alert) ?>!</h4>
                                <p><?php echo humanize($message) ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
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
                                    if(in_array('u',$this->sso_new->curr_access))
                                        $row->{$key[1]} .= anchor($base . '/update/' . $row->$id, '<i class="fa fa-edit"></i>' . nbs() . 'Edit', 'title="Edit data"') . nbs(2) . '<span class="text-muted small"></span>' . nbs(2);
                                    
                                    if(in_array('d',$this->sso_new->curr_access))
                                        $row->{$key[1]} .= anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete row" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url($base . '/delete/' . $row->$id) . '"');
                                    
                                    $row->{$key[1]} .= '</div>';
                                    if ($show_pk === FALSE)
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