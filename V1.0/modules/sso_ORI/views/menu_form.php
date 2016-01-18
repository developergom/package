<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php echo form_open('sso/menus/act/', 'class="form-horizontal"', ['mid' => (isset($data['mid'])) ? $data['mid'] : NULL]) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Form user', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"><?php echo validation_errors() ?></div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Name', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('mnme', (isset($data['mnme'])) ? $data['mnme'] : set_value('mnme'), 'class="form-control" placeholder="Name" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('mnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Is Sub From', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_dropdown('mpar', option_recursive($opt, 'mid', 'mnme'), [(isset($data['mpar'])) ? $data['mpar'] : NULL], 'class="form-control" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('mpar'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Url/Link', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('mlnk', (isset($data['mlnk'])) ? $data['mlnk'] : set_value('mlnk'), 'class="form-control" placeholder="Url/Link" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('mlnk'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Order', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <?php echo form_input('mordr', (isset($data['mordr'])) ? $data['mordr'] : set_value('mordr'), 'class="form-control" placeholder="Sort Order" data-bv-notempty="true" data-bv-numeric="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('mlnk'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Icon', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('mico', (isset($data['mico'])) ? $data['mico'] : set_value('mico'), 'class="form-control" placeholder="Icon" data-bv-notempty="true" readonly') ?>
                    </div>
                    <?php //echo form_label(form_error('mico'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <?php echo form_label(form_checkbox('mstat', TRUE, (isset($data['mstat']) && $data['mstat']) ? TRUE : FALSE) . ' Is Active ?') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        <?php echo anchor('sso/menus/', '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>