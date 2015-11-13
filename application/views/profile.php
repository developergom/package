<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <?php echo heading('<i class="fa fa-user"></i> Your profile', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="alert alert-warning alert-dismissable">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                            <?php echo heading('<h4><i class="icon fa fa-warning"></i> Attention!', 4) ?>
                            If there is something wrong with your data, please contact administrator immediately.
                        </div>
                    </div>
                    <div class="col-xs-7 col-md-7">
                        <div class="form-group">
                            <?php echo form_label('Username', '', array('class' => 'col-md-4 control-label')) ?>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo $this->usr->unme ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Fullname', '', array('class' => 'col-md-4 control-label')) ?>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo $this->usr->ufnme ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Nickname', '', array('class' => 'col-md-4 control-label')) ?>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo $this->usr->uninme ?></p>
                            </div>
                        </div>
                        <div class="form-group" id="birth-section">
                            <?php echo form_label('Birthdate', '', array('class' => 'col-md-4 control-label')) ?>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo mdate('%d/%m/%Y',strtotime($this->usr->ubirth)) ?>
                                    <div class="small action" id="qe-profile" style="margin: 10px 0px">
                                        <a href="javascript:void(0)" class="quick-edit" id="qt-profile" title="Quick edit birthdate"><i class="fa fa-pencil"></i>  Quick Edit</a>
                                    </div>
                                    <div class="quick-form-profile" id="qf-profile">
                                        <?php echo form_open('profile/change_birth', 'class="form-horizontal"', array('uid' => (isset($this->usr->uid)) ? $this->usr->uid : set_value('uid'), 'quick' => TRUE)) ?>
                                        <div class="form-group">
                                            <?php echo form_label('Birthdate', 'ubirth', array('class' => 'col-xs-4 col-md-2 control-label')) ?>
                                            <div class="col-xs-4 col-md-10">
                                                <?php echo form_input('ubirth', mdate('%d/%m/%Y',strtotime($this->usr->ubirth)), 'class="input-sm form-control" id="ubirth" placeholder="dd/mm/yyyy" data-inputmask="\'alias\':\'dd/mm/yyyy\'" data-mask') ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                <button type="button" class="btn btn-sm btn-default" id="cqe-profile">Cancel</button>
                                            </div>
                                        </div>
                                        <?php echo form_close() ?>
                                    </div>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Email', '', array('class' => 'col-md-4 control-label')) ?>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo $this->usr->umail ?></p>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-5 col-md-5">
                        <img src="asset/img/avatar/<?php echo $this->session->userdata('uava'); ?>" class="pull-left img-thumbnail" style="width:150px;">
                    </div>
                    <div class="col-xs-5 col-md-5" id="avatar-section">
                        <div class="small action-avatar" id="qe-avatar" style="margin: 10px 0px">
                            <a href="javascript:void(0)" class="quick-edit" id="qt-avatar" title="Change avatar"><i class="fa fa-pencil"></i> Change Avatar</a>
                        </div>
                        <div class="quick-form-avatar" id="qf-avatar">
                            <?php echo form_open('profile/change_ava', 'class="form-horizontal" enctype="multipart/form-data"', array('uid' => (isset($this->usr->uid)) ? $this->usr->uid : set_value('uid'), 'quick' => TRUE)) ?>
                            <div class="form-group">
                                <div class="col-xs-4 col-md-10">
                                    <input type="file" name="upp" id="upp" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-sm btn-primary">Change</button>
                                    <button type="button" class="btn btn-sm btn-default" id="cqe-avatar">Cancel</button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"><?php echo nbs() ?></div>
                <div class="row">
                    <?php echo form_open('profile/change/', 'class="form-horizontal" role="form" data-toggle="validator"', array('uid' => (isset($this->usr->uid)) ? $this->usr->uid : set_value('uid'))) ?>
                    <div class="col-md-10 col-md-offset-1"><?php echo validation_errors() ?></div>
                    <div class="col-xs-10 col-xs-offset-1 col-md-7 col-md-offset-1">
                        <div class="form-group has-feedback">
                            <?php echo form_label('New password', '', array('class' => 'col-xs-4 col-md-4 control-label')) ?>
                            <div class="col-xs-8 col-md-8">
                                <?php echo form_password('npass', set_value('npass'), 'class="form-control" placeholder="New password" data-bv-stringlength="true" data-bv-stringlength-min="8" data-bv-notempty="true"') ?>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <?php echo form_label('Retype password', '', array('class' => 'col-xs-4 col-md-4 control-label')) ?>
                            <div class="col-xs-8 col-md-8">
                                <?php echo form_password('rpass', '', 'class="form-control" placeholder="Retype password" data-bv-notempty="true" data-bv-notempty-message="The confirm password is required and cannot be empty" data-bv-identical="true" data-bv-identical-field="npass" data-bv-identical-message="The password and its confirm are not the same"') ?>
                            </div>
                        </div>
                        <div class="clearfix"><?php echo nbs() ?></div>
                        <div class="form-group">
                            <div class="col-xs-offset-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="box-footer clearfix"><?php echo nbs() ?></div>
        </div>
    </div>
</div>