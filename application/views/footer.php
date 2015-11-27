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
            'raphael-2.1.0.min', 
            'morris.min', 
            'jquery.sparkline.min',
            'jquery.knob', 
            'daterangepicker', 
            'bootstrap-datepicker', 
            'bootstrap3-wysihtml5.all.min', 
            'jquery.slimscroll.min', 
            'fastclick.min', 
            'demo',
            'app.min',
            'jquery.inputmask',
            'jquery.inputmask.date.extensions',
            'jquery.inputmask.extensions'
        ];
        foreach ($js as $v)
            echo script_tag($v);
                
        if(!empty($script)) {
            if(!is_array($script)) 
                $script = array($script);

            foreach($script as $_script)
                echo script_tag($_script);                
        }
        ?>
        <script type="text/javascript">
            $.widget.bridge('uibutton', $.ui.button);
            "use strict";
            $(function () {
                var base_url = window.location.protocol + '//' + window.location.host + '/package/';
                //var base_url = window.location.protocol + '//' + window.location.host + '/';
                
                $('.form-horizontal').bootstrapValidator({
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    }
                });
                
                $('#confirm-delete').on('show.bs.modal', function(e) {
                    $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
                });
                
                $('.connectedSortable').sortable({
                    placeholder: "sort-highlight",
                    connectWith: ".connectedSortable",
                    handle: ".box-header, .nav-tabs",
                    forcePlaceholderSize: true,
                    zIndex: 999999
                });
                $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');
                
                $('.quick-form').hide();
                $('tr.tr').each(function() {
                    $('.action').css('visibility', 'hidden');
                    var id = $(this).data('key');
                    $(this).mouseover(function() {
                        $('#qe-' + id).css('visibility', 'visible');
                    }).mouseleave(function() {
                        $('#qe-' + id).css('visibility', 'hidden');
                    });

                    $('#qt-' + id).click(function(e) {
                        e.preventDefault();
                        $('#qf-' + id).fadeIn();
                    });
                    
                    $('#cqe-' + id).click(function() {
                        $('#qf-' + id).fadeOut();
                    });
                });
                
                setInterval(function () {
                    $('.alert').fadeOut();
                }, 7000);

                /** PROFILE SECTION **/
                $('#qf-profile').hide();
                $('.action').css('visibility', 'hidden');
                $('#birth-section').mouseover(function(){
                    $('#qe-profile').css('visibility', 'visible');
                }).mouseleave(function(){
                    $('#qe-profile').css('visibility', 'hidden');
                });
                $('#qt-profile').click(function(e){
                    e.preventDefault();
                    $('#qf-profile').fadeIn();
                });
                $('#cqe-profile').click(function() {
                    $('#qf-profile').fadeOut();
                });

                //Datemask dd/mm/yyyy
                $("#ubirth").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

                $('#qf-avatar').hide();
                $('.action-avatar').css('visibility', 'hidden');
                $('#avatar-section').mouseover(function(){
                    $('#qe-avatar').css('visibility', 'visible');
                }).mouseleave(function(){
                    $('#qe-avatar').css('visibility', 'hidden');
                });
                $('#qt-avatar').click(function(e){
                    e.preventDefault();
                    $('#qf-avatar').fadeIn();
                });
                $('#cqe-avatar').click(function() {
                    $('#qf-avatar').fadeOut();
                });

                /*****************************/
                /*********END PROFILE*********/
            });
        </script>
    </body>
</html>