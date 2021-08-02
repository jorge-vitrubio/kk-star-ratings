<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }
?>

<div class="kksr-icon" style="width: <?= esc_attr($size) ?>px; height: <?= esc_attr($size) ?>px;"></div>
