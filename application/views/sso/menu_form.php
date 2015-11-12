<div class="row">
    <div class="col-md-12">
        <div class="box">
            <?php echo form_open('sso/menus/act/', 'class="form-horizontal"', array('mid' => (isset($data['mid'])) ? $data['mid'] : null)) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Form user', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"><?php echo validation_errors() ?></div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Name', '', array('class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label')) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('mnme', (isset($data['mnme'])) ? $data['mnme'] : set_value('mnme'), 'class="form-control" placeholder="Name" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('mnme'), '', array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Is Sub From', '', array('class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label')) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_dropdown('mpar', option_recursive(data_recursive($opt, 'mid', 'mpar'), 'mid', 'mnme'), array((isset($data['mpar'])) ? $data['mpar'] : null), 'class="form-control" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('mpar'), '', array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Url/Link', '', array('class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label')) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('mlnk', (isset($data['mlnk'])) ? $data['mlnk'] : set_value('mlnk'), 'class="form-control" placeholder="Url/Link" data-bv-notempty="true"') ?>
                    </div>
                    <?php //echo form_label(form_error('mlnk'), '', array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Icon', '', array('class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label')) ?>
                    <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                        <?php echo form_input('mico', (isset($data['mico'])) ? $data['mico'] : set_value('mico'), 'class="form-control" placeholder="Icon" data-bv-notempty="true" readonly') ?>
                    </div>
                    <?php //echo form_label(form_error('mico'), '', array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <?php echo form_label(form_checkbox('mstat', true, (isset($data['mstat']) && $data['mstat']) ? true : false) . ' Is Active ?') ?>
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