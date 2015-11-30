<div class="row">
    <?php if (in_array('c', $this->sso->access)) { ?>
        <div class="col-md-4 connectedSortable ui-sortable">
            <div class="box box-info">
                <?php echo form_open('sso/roles/act/', 'class="form-horizontal"') ?>
                <div class="box-header ui-sortable-handle">
                    <?php echo heading('<i class="fa fa-pencil"></i> New roles', 3, 'class="box-title"') ?>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group has-feedback">
                        <?php echo form_label('Name', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-10">
                            <?php echo form_input('rnme', set_value('rnme'), 'class="form-control" placeholder="Role Name" data-bv-notempty="true"') ?>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <?php echo form_label('Desc', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-10">
                            <?php echo form_textarea('rdesc', set_value('rdesc'), 'class="form-control" placeholder="Role Description" data-bv-notempty="true"') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <?php echo form_label(form_checkbox('rstat', TRUE, TRUE) . ' Is Active ?') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    <?php } ?>
    <div class="<?php echo ((in_array('c', $this->sso->access))) ? 'col-md-8' : 'col-md-12' ?> connectedSortable ui-sortable">
        <div class="box box-info">
            <div class="box-header ui-sortable-handle">
                <?php echo heading('<i class="fa fa-list"></i> List roles', 3, 'class="box-title"') ?>
                <div class="box-tools">
                    <?php echo form_open('sso/roles/', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', NULL, 'class="form-control input-sm" placeholder="Search role"') ?>
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
                        <th class="text-center"><?php echo anchor(current_url() . '/?sort=rnme', 'Name <i class="pull-right fa fa-sort"></i>') ?></th>
                        <th class="text-center"><?php echo anchor(current_url() . '/?sort=rdesc', 'Description <i class="pull-right fa fa-sort"></i>') ?></th>
                        <th class="text-center">Last updated</th>
                    </tr>
                    <?php
                    if (!empty($data)) {
                        foreach ($data as $k => $v) {
                            $stat = ($v['rstat'] == FALSE) ? 'danger' : NULL;
                            ?>
                            <tr class="tr <?php echo $stat ?>" data-key="<?php echo $v['rid'] ?>">
                                <td>
                                    <?php echo ($v['rstat'] == FALSE) ? $v['rnme'] . ' <small class="text-muted">(Inactive)</small>' : $v['rnme'] ?>
                                    <div class="small action" id="qe-<?php echo $v['rid'] ?>">
                                        <?php
                                        if (in_array('u', $this->sso->access)) {
                                            echo anchor('sso/roles/form/' . $v['rid'], '<span class="fa fa-edit"></span>' . nbs() . 'Edit', 'title="Edit role"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                            echo anchor('#', '<i class="fa fa-pencil"></i>  Quick Edit', 'class="quick-edit" id="qt-' . $v['rid'] . '" title="Fast edit role"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
                                        }
                                        if (in_array('d', $this->sso->access))
                                            echo anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete role" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url('sso/roles/erase/' . $v['rid']) . '"');
                                        ?>
                                    </div>
                                    <div class="quick-form" id="qf-<?php echo $v['rid'] ?>">
                                        <?php echo form_open('sso/roles/act', 'class="form-horizontal"', ['rid' => $v['rid']]) ?>
                                        <div class="form-group">
                                            <?php echo form_label('Name', 'rnme', ['class' => 'col-xs-4 col-md-2 control-label']) ?>
                                            <div class="col-xs-4 col-md-10">
                                                <?php echo form_input('rnme', $v['rnme'], 'class="input-sm form-control" id="rnme" placeholder="Role name"') ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Update role</button>
                                                <button type="button" class="btn btn-sm btn-default" id="cqe-<?php echo $v['rid'] ?>">Cancel</button>
                                            </div>
                                        </div>
                                        <?php echo form_close() ?>
                                    </div>
                                </td>
                                <td><?php echo $v['rdesc'] ?></td>
                                <td>
                                    <?php echo mdate('%F %j, %Y on %H:%i', strtotime($v['ud'])) . br() . '<span class="small text-muted">' . time_elapsed($v['ud']) . nbs() . '<em>by</em>' . nbs() . $v['ufnme'] . '</span>' ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
                <em class="pull-right small text-muted"><?php echo br() . singular_plural($row, 'row') ?></em>
            </div>
            <div class="box-footer clearfix">
                <nav><?php echo (isset($pagination)) ? $pagination : nbs() ?></nav>
            </div>
        </div>
    </div>    
</div>