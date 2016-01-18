<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php echo form_open('sso/users/act/', 'class="form-horizontal"', ['uid' => (isset($data['uid'])) ? $data['uid'] : NULL]) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Form user', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"><?php echo validation_errors() ?></div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Username', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('unme', (isset($data['unme'])) ? $data['unme'] : set_value('unme'), (isset($data['unme'])) ? 'readonly class="form-control" placeholder="Username" data-bv-notempty="true"' : 'class="form-control" placeholder="Username" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('unme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Password', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_password('upass', NULL, 'class="form-control" placeholder="Password"') ?>
                    </div>
                    <?php //echo form_label(form_error('upass'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Fullname', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('ufnme', (isset($data['ufnme'])) ? $data['ufnme'] : set_value('ufnme'), 'class="form-control" placeholder="Fullname" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('ufnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Nickname', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('uninme', (isset($data['uninme'])) ? $data['uninme'] : set_value('uninme'), 'class="form-control" placeholder="Nickname" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('ufnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Email', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('umail', (isset($data['umail'])) ? $data['umail'] : set_value('umail'), 'class="form-control" placeholder="Email" data-bv-notempty="true" data-bv-emailaddress="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('umail'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Signed into', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_multiselect('rl[]', $rldata, (isset($urldata)) ? $urldata : [], 'class="form-control" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('rl'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <?php echo form_label(form_checkbox('ustat', TRUE, (isset($data['ustat']) && $data['ustat']) ? TRUE : FALSE) . ' Is Active ?') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        <?php echo anchor('sso/users/', '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>