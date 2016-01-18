<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php echo form_open('sso/roles/act/', 'class="form-horizontal"', ['rid' => (isset($data['rid'])) ? $data['rid'] : NULL]) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Edit roles', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="form-group has-feedback">
                    <?php echo form_label('Name', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <?php echo form_input('rnme', (isset($data['rnme'])) ? $data['rnme'] : set_value('rnme'), 'class="form-control" placeholder="Role Name" data-bv-notempty="true"') ?>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Description', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <?php echo form_textarea('rdesc', (isset($data['rdesc'])) ? $data['rdesc'] : set_value('rdesc'), 'class="form-control" placeholder="Role Description" data-bv-notempty="true"') ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <?php echo form_label(form_checkbox('rstat', TRUE, ($data['rstat']) ? TRUE : FALSE) . ' Is Active ?') ?>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header"><?php echo heading('Application Menu', 3, 'class="box-title"') ?></div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-bordered">
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
                                        $checked = FALSE;
                                        foreach ($acc_key as $kk => $vv) {
                                            if (isset($rmdata)) {
                                                foreach ($rmdata as $kkk => $vvv) {
                                                    if ($v['mid'] != $kkk)
                                                        continue;

                                                    $checked = ($v['mid'] == $kkk && in_array($kk, $vvv)) ? TRUE : FALSE;
                                                }
                                            } else {
                                                $checked = ($kk == 'r') ? TRUE : FALSE;
                                            }
                                            
                                            $readonly = ($kk == 'r') ? 'disabled' : NULL;
                                            ?>
                                            <th class="text-center">
                                            <div class="checkbox <?php echo $readonly ?>">
                                                <?php echo form_label(form_checkbox('acc[' . $v['mid'] . '][]', $kk, $checked, 'class="acc-' . $v['mid'] . '"' . $readonly)) ?>
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