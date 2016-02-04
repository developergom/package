<?php if (!empty($medias)): ?>
    <?php foreach ($medias as $media): ?>
        <li class="span6 col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <a class="thumbnail" href="javascript:void(0)"  onclick="chooseImage('<?php echo base_url($media['media_path']) ?>')" >
                <img style="height:100px;width:130px;" src="<?php echo base_url($media['media_path']) ?>">
            </a>
        </li>
    <?php endforeach; ?>
<!--    <li class="col-md-12">
        <?php if ($current_page > 1): ?>
            <a href="javascript:browseImage(<?php echo $current_page - 1 ?>)" class="pull-left btn btn-default">Prev</a>
        <?php endif; ?>
        <?php if ($current_page < $total_pages): ?>
            <a href="javascript:browseImage(<?php echo $current_page + 1 ?>)" class="pull-right btn btn-default">Next</a>
        <?php endif; ?>
    </li>-->
<?php endif; ?>