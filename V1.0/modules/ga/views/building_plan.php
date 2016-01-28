<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <div class="row">
                    <div class="col-lg-6"><?php echo heading(anchor('ga/building_plan/create/', 'New'), 4, 'class="pull-left"') ?></div>
                </div>
            </div>
            <div class="box-body">
                <?php
                $this->table->set_heading(['desc', 'unit', 'level', 'status', '']);
                foreach ($building_plan as $index => $row) {
                    $row->building_plan_description = anchor('ga/building_plan/update/' . $row->building_plan_id, $row->building_plan_description);
                    $row->del = anchor('ga/building_plan/delete/' . $row->building_plan_id, 'Delete');
                    unset($row->building_plan_id);
                    $this->table->add_row(object_to_array($row));
                }

                echo $this->table->generate();
                ?>
            </div>
            <div class="box-footer"><?php echo $links ?></div>
        </div>
    </div>    
</div>