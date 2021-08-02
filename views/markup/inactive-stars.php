<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }
?>

<div class="kksr-stars-inactive">
    <?php for ($i = 1; $i <= $best; $i++) : ?>
        <div class="kksr-star" data-star="<?= esc_attr($i) ?>" <?= isset($gap) ? ('style="padding-'.(is_rtl() ? 'left' : 'right').': '.esc_attr($gap).'px"') : '' ?>>
            <?= $__view('markup/inactive-star.php') ?>
        </div>
    <?php endfor; ?>
</div>
