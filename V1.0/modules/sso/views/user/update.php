<div class="row">
    <div class="col-sm-12">
        <div class="box box-info">
            <?php echo form_open($action, 'class="form-horizontal"', isset($record) ? [$id => $record->{$id}] : []) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Update Form', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <?php if(!empty(validation_errors())) { ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-info"></i> Alert!</h4>
                            <?php echo validation_errors() ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php
                    foreach ($form as $index => $row) {
                        $type = 'form_' . $row['type'];
                        $is_required = (in_array('required', explode('|', $row['rules']))) ? 'data-bv-notempty="true"' : NULL;
                        $is_numeric = (in_array('numeric', explode('|', $row['rules']))) ? 'data-bv-numeric="true"' : NULL;
                        $is_email = ($row['type'] == 'email') ? 'data-bv-emailaddress="true"' : NULL;
                        if ($row['type'] == 'checkbox') {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <?php echo form_label($type($row['name'], 'active', (bool) (isset($record->{$row['name']}) && $record->{$row['name']} == 'active')) . nbs() . $row['label']) ?>
                                </div>
                            </div>
                            <?php
                        } else if ($row['type'] == 'date') {
                            ?>
                            <div class="form-group has-feedback">
                                <?php echo form_label($row['label'], NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                                <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo $type($row['name'], isset($record->{$row['name']}) ? $record->{$row['name']} : set_value($row['name']), 'class="form-control datepicker"' . $is_required) ?>
                                    </div>
                                </div>
                                <?php //echo form_label(form_error($row['name']), NULL, ['class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3']) ?>
                            </div>
                            <?php
                        } else if ($row['type'] == 'dropdown') {
                            ?>
                            <div class="form-group has-feedback">
                                <?php echo form_label($row['label'], NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                                <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                                    <?php echo $type($row['name'], isset($row['items']) ? $row['items'] : [], isset($record->{$row['name']}) ? $record->{$row['name']} : set_select($row['name']), 'class="form-control" placeholder="' . humanize($row['name']) . '"' . $is_required . $is_numeric . $is_email) ?>
                                </div>
                                <?php //echo form_label(form_error('$row['name']'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3'))  ?>
                            </div>
                            <?php
                        } else if($row['type'] == 'multiselect') {
                             ?>
                            <div class="form-group has-feedback">
                                <?php echo form_label($row['label'], NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                                <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                                    <?php echo $type($row['name'], isset($row['items']) ? $row['items'] : [], isset($record->{$row['name']}) ? $record->{$row['name']} : set_select($row['name']), 'class="form-control" placeholder="' . humanize($row['name']) . '"' . $is_required . $is_numeric . $is_email) ?>
                                </div>
                                <?php //echo form_label(form_error('$row['name']'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3'))  ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="form-group has-feedback">
                                <?php echo form_label($row['label'], NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                                <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                                    <?php echo $type($row['name'], isset($record->{$row['name']}) ? $record->{$row['name']} : set_value($row['name']), 'class="form-control" placeholder="' . humanize($row['name']) . '"' . $is_required . $is_numeric . $is_email) ?>
                                </div>
                                <?php //echo form_label(form_error('$row['name']'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3'))  ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        <?php echo anchor($base, '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>