<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">
                    <?php
                    if (in_array('c', $this->sso->access))
                        echo anchor('#', '<span class="fa fa-plus"></span> New Country');
                    ?>
                </h3>
            </div>
            <div class="box-body">
                <?php
                    //$this->table->set_heading([]);
                ?>
                <table class="table table-hover dataTable" data-url="<?php echo base_url('residence/country/dataTables/') ?>">
                    <thead>
                        <tr>
                            <th class="text-center">Code</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">ISO3 Code</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>    
</div>