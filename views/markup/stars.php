<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }
?>

<div class="kksr-stars">
    <?= $__view('markup/inactive-stars.php') ?>
    <?= $__view('markup/active-stars.php') ?>
</div>
