<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }
?>

<div class="kksr-legend">
    <?php if ($count) : ?>
        <?= esc_html($legend) ?>
    <?php else : ?>
        <span class="kksr-muted"><?= esc_html($greet) ?></span>
    <?php endif; ?>
</div>
