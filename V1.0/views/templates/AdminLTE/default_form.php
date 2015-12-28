<div class="row">
    <div class="col-sm-12">
        <div class="box box-info">
            <?php echo form_open($action, 'class="form-horizontal"', $key) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Form', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <!--<div class="col-md-10 col-md-offset-1"><?php //echo validation_errors()    ?></div>-->
                    <?php
                    foreach ($field as $index => $row) :
                        $form = 'form_' . $row->form;
                        $is_required = (in_array('required', explode('|', $row->rules))) ? 'data-bv-notempty="true"' : NULL;
                        $is_email = ($row->form == 'email') ? 'data-bv-emailaddress="true"' : NULL;
                        if ($row->form == 'checkbox') {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <?php echo form_label($form($row->name, TRUE, (isset($data[$row->name]) && $data[$row->name]) ? TRUE : FALSE) . nbs() . 'Is Active ?') ?>
                                </div>
                            </div>
                            <?php
                        } else if ($row->form == 'date') {
                            ?>
                            <div class="form-group has-feedback">
                                <?php echo form_label($row->label, NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                                <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo $form($row->name, (isset($data[$row->name])) ? $data[$row->name] : set_value($row->name), 'class="form-control datepicker"' . $is_required) ?>
                                    </div>
                                </div>
                                <?php echo form_label(form_error($row->name), NULL, ['class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3']) ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="form-group has-feedback">
                                <?php echo form_label($row->label, NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                                <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                                    <?php echo $form($row->name, (isset($data[$row->name])) ? $data[$row->name] : set_value($row->name), 'class="form-control" placeholder="' . $row->label . '"' . $is_required . $is_email) ?>
                                </div>
                                <?php echo form_label(form_error($row->name), NULL, ['class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3']) ?>
                            </div>
                            <?php
                        }
                    endforeach;
                    ?>
                </div>
            </div>
            <div class="box-footer clearfix">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        <?php echo anchor($this->setting->uri_string(), '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>