<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <?php if ($this->setting->can_create()) : ?>
                <div class="box-header">
                    <?php echo heading(anchor($create, '<i class="fa fa-plus"></i> Create New'), 3, 'class="box-title"') ?>
                </div>
            <?php endif ?>
            <div class="box-body">
                <?php echo (isset($datagrid)) ? $datagrid : nbs() ?>
            </div>
        </div>
    </div>    
</div>