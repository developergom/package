<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header"></div>
            <div class="box-body">
                <?php 
                    $this->table->set_heading(['id', 'name', 'unit', 'level', 'status']);
                    echo $this->table->generate(object_to_array($building_plan));
                ?>
            </div>
            <div class="box-footer"><?php echo $links ?></div>
        </div>
    </div>    
</div>