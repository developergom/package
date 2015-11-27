<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">
                    <?php
                    if (in_array('c', $this->sso->access))
                        echo anchor('sso/users/form', '<span class="fa fa-plus"></span> New User');
                    ?>
                </h3>
                <div class="box-tools">
                    <?php echo form_open('sso/users/', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', '', 'class="form-control pull-right" placeholder="Search user"') ?>
                        <div class="input-group-btn">
                            <button class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th class="text-center"><?php echo anchor(current_url() . '/?sort=unme', 'Username <i class="pull-right fa fa-sort"></i>') ?></th>
                        <th class="text-center"><?php echo anchor(current_url() . '/?sort=ufnme', 'Name <i class="pull-right fa fa-sort"></i>') ?></th>
                        <th class="text-center"><?php echo anchor(current_url() . '/?sort=umail', 'Email <i class="pull-right fa fa-sort"></i>') ?></th>
                        <th class="text-center">Last activity</th>
                    </tr>
                    <?php
                    if (!empty($data)) {
                        foreach ($data as $k => $v) {
                            $stat = ($v['ustat'] == FALSE) ? 'danger' : NULL;
                            ?>
                            <tr class="tr <?php echo $stat ?>" data-key="<?php echo $v['unme'] ?>">
                                <td>
                                    <span class="text-muted"><?php echo $v['unme'] ?></span>
                                    <div class="small action" id="qe-<?php echo $v['unme'] ?>">
                                        <?php
                                        if (in_array('u', $this->sso->access))
                                            echo anchor('sso/users/form/' . $v['uid'], '<i class="fa fa-edit"></i>' . nbs() . 'Edit', 'title="Edit user"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);

                                        if (in_array('d', $this->sso->access))
                                            echo anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete user" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url('sso/users/erase/' . $v['uid']) . '"');
                                        ?>
                                    </div>
                                </td>
                                <td><?php echo $v['ufnme'] . br() . '<em class="small">' . $v['uninme'] . '</em>' ?></td>
                                <td><?php echo mailto($v['umail'], $v['umail'], 'title="Send mail to ' . $v['ufnme'] . ' ?"'); ?></td>
                                <td>
                                    <?php echo mdate('%F %j, %Y on %H:%i', strtotime($v['ud'])) . br() . '<span class="small text-muted">' . time_elapsed($v['ud']) . '</span>' ?>
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