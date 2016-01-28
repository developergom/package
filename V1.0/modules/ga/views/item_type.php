<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <div class="row">
                    <div class="col-lg-6"><?php echo heading(anchor('ga/item_type/create/', 'New'), 4, 'class="pull-left"') ?></div>
                </div>
            </div>
            <div class="box-body">
                <?php
                $this->table->set_heading(['name', 'desc', 'status', '']);
                foreach ($item_type as $index => $row) {
                    $row->item_type_name = anchor('ga/item_type/update/' . $row->item_type_id, $row->item_type_name);
                    $row->del = anchor('ga/item_type/delete/' . $row->item_type_id, 'Delete');
                    unset($row->item_type_id);
                    $this->table->add_row(object_to_array($row));
                }

                echo $this->table->generate();
                ?>
            </div>
            <div class="box-footer"><?php echo $links ?></div>
        </div>
    </div>    
</div>