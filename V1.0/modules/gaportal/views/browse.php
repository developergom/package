<?php
if (!empty($medias)) {
    ?> <ul> <?php
        foreach ($medias as $media) {
            ?>
            <li>
                <img src="<?php echo $media['media_path'] ?>">

            </li>
            <?php
        }
        ?> </ul><?php
} else {
    echo 'empty...';
}
?>