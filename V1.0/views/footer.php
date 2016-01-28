</section>
</div><!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y') ?></strong> All rights reserved.
</footer>
</div><!-- ./wrapper -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <span class="fa fa-warning"></span>
                <strong> Are you sure want to delete this data ?</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<?php
$js = [
    'jQuery-2.1.4.min',
    'jquery-ui.min',
    'bootstrap.min',
    'bootstrap-validator.min',
    //'raphael-2.1.0.min',
    //'morris.min',
    //'jquery.sparkline.min',
    //'jquery.knob',
    'icheck.min',
    'select2.min',
    'bootstrap-datepicker',
    //'bootstrap3-wysihtml5.all.min',
    //'jquery.slimscroll.min',
    //'fastclick.min',
    //'demo',
    'app.min'
];
foreach ($js as $v)
    echo script_tag($v);

if (!empty($script)) {
    if (!is_array($script))
        $script = array($script);

    foreach ($script as $_script)
        echo script_tag($_script);
}

echo script_tag('initialize');
?>

</body>
</html>