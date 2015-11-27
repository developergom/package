<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <?php
                if (in_array('c', $this->sso->access))
                    echo anchor('sso/menus/form', '<i class="fa fa-plus"></i> New Menu', 'class="box-title"');
                ?>
                <div class="box-tools">
                    <?php echo form_open('sso/menus/', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', NULL, 'class="form-control input-sm" placeholder="Search menu"') ?>
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Icon</th>
                        <th class="text-center">Link/URL</th>
                        <th class="text-center">Last update</th>
                    </tr>
                    <?php
                    if (!empty($data)) {
                        foreach ($data as $k => $v) {
                            $stat = ($v['mstat'] == FALSE) ? 'danger' : NULL;
                            ?>
                            <tr class="tr <?php echo $stat ?>" data-key="<?php echo $v['mid'] ?>">
                                <td>
                                    <?php echo ($v['mstat'] == FALSE) ? $v['mnme'] . ' <small class="text-muted">(Inactive)</small>' : $v['mnme'] ?>
                                    <div class="small action" id="qe-<?php echo $v['mid'] ?>">
                                        <?php
                                        if ($v['mpar'] != FALSE) {
                                            if (in_array('u', $this->sso->access)) {
                                                echo anchor('sso/menus/form/' . $v['mid'], '<span class="fa fa-edit"></span>' . nbs() . 'Edit', 'title="Edit menu"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                                echo anchor('#', '<i class="fa fa-pencil"></i>  Quick Edit', 'class="quick-edit" id="qt-' . $v['mid'] . '" title="Fast edit menu"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                            }
                                            if (in_array('d', $this->sso->access))
                                                echo anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete menu" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url('sso/menus/erase/' . $v['mid']) . '"');
                                        }
                                        ?>
                                    </div>
                                    <div class="quick-form" id="qf-<?php echo $v['mid'] ?>">
                                        <?php echo form_open('sso/menus/act', 'class="form-horizontal"', array('mid' => $v['mid'], 'quick' => TRUE)) ?>
                                        <div class="form-group">
                                            <?php echo form_label('Name', 'mnme', array('class' => 'col-xs-4 col-md-2 control-label')) ?>
                                            <div class="col-xs-4 col-md-10">
                                                <?php echo form_input('mnme', str_replace('_', NULL, $v['mnme']), 'class="input-sm form-control" id="mnme" placeholder="Menu name"') ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-sm btn-primary">Update menu</button>
                                                <button type="button" class="btn btn-sm btn-default" id="cqe-<?php echo $v['mid'] ?>">Cancel</button>
                                            </div>
                                        </div>
                                        <?php echo form_close() ?>
                                    </div>
                                </td>
                                <td class="text-center"><span class="fa <?php echo $v['mico'] ?>"></span></td>
                                <td><?php echo base_url($v['mlnk']) ?></td>
                                <td><?php echo mdate('%F %j, %Y on %H:%i', strtotime($v['ud'])) . br() . '<span class="small text-muted">' . time_elapsed($v['ud']) . nbs() . '<em>by</em>' . nbs() . $v['ufnme'] . '</span>' ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
                <em class="pull-right small text-muted"><?php echo br() . singular_plural($row, 'row') ?></em>
            </div>
            <div class="box-footer clearfix"><nav><?php echo (isset($pagination)) ? $pagination : NULL ?></nav></div>
        </div>
    </div>    
</div>