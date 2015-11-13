<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <?php echo form_open('sso/roles/act/', null, array('rid' => $data['rid'])) ?><div class="box-body">
                <div class="box-header">
                    <?php echo heading('<i class="fa fa-pencil"></i> Edit roles', 3, 'class="box-title"') ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group has-feedback">
                        <?php
                        echo form_label('Name');
                        echo form_input('rnme', $data['rnme'], 'class="form-control" placeholder="Role Name" data-bv-notempty="true"');
                        echo form_label(form_error('rnme'));
                        ?>
                    </div>
                    <div class="checkbox">
                        <?php echo form_label(form_checkbox('rstat', TRUE, ($data['rstat']) ? TRUE : FALSE) . ' Is Active ?') ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Menu name</th>
                                <?php
                                foreach ($acc_key as $v) {
                                    ?>
                                    <th class="text-center"><?php echo $v ?></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                            $mdata = data_recursive($mdata, 'mid', 'mpar');
                            $recursive = datagrid_recursive($mdata, 'mnme');
                            if (!empty($recursive)) {
                                foreach ($recursive as $v) {
                                    if ($v['mpar'] == FALSE)
                                        continue;
                                    ?>
                                    <tr>
                                        <th class="text-center">
                                    <div class="checkbox all"><?php echo form_label(form_checkbox('mid_' . $v['mid'], '', '', 'data-mid="' . $v['mid'] . '"')) ?></div>
                                    </th>
                                    <td><?php echo $v['mnme'] ?></td>
                                    <?php
                                    $checked = false;
                                    foreach ($acc_key as $kk => $vv) {
                                        if (isset($rmdata)) {
                                            foreach ($rmdata as $kkk => $vvv) {
                                                if ($v['mid'] != $kkk)
                                                    continue;

                                                $checked = ($v['mid'] == $kkk && in_array($kk, $vvv)) ? true : false;
                                            }
                                        } else {
                                            $checked = ($kk == 'r') ? true : false;
                                        }
                                        ?>
                                        <th class="text-center">
                                        <div class="checkbox">
                                            <?php echo form_label(form_checkbox('acc[' . $v['mid'] . '][]', $kk, $checked, 'class="acc-' . $v['mid'] . '"')) ?>
                                        </div>
                                        </th>
                                        <?php
                                    }
                                    ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                    <?php echo anchor('sso/roles/', '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>