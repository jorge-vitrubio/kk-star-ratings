<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }
?>

<div class="wrap">
    <?php if ($globalErrors) : foreach ($globalErrors as $error) : ?>
        <div class="notice notice-error">
            <p><?= esc_html($error) ?></p>
        </div>
    <?php endforeach; endif; ?>

    <?php if ($processed) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?= esc_html(__('Options saved.', 'kk-star-ratings')) ?></p>
        </div>
    <?php endif; ?>

    <h1>
        <?= esc_html($label) ?>
        <small style="
            color: gray;
            margin-left: .5rem;
            letter-spacing: -2px;
            font-family: monospace;">
            <?= esc_html($version) ?>
        </small>
        <small>
            by
            <a href="<?= esc_attr($authorUrl) ?>" target="_blank">
                <?= esc_html($author) ?>
            </a>
        </small>
    </h1>

    <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab => $tabMeta) : ?>
            <a class="nav-tab <?= ($tabMeta['is_active'] ?? false) ? 'nav-tab-active' : '' ?>"
                style="position: relative; border-radius: 4px 4px 0 0; <?= ($tabMeta['is_addon'] ?? false) ? (($tabMeta['is_active'] ?? false) ? 'background-color: auto; border-color: auto;' : 'background-color: #f6efc7; border-color: #ead2ae;') : '' ?>"
                href="<?= admin_url('admin.php?page='.esc_attr($_GET['page'] ?? '').'&tab='. urlencode(esc_attr($tab))) ?>">
                <?= esc_html($tab) ?>
                <?php if ($tabMeta['is_addon'] ?? false) : ?>
                    <span style="position: absolute; z-index: 10; top: -9px; right: -9px; display: flex; align-items: center; justify-content: center; width: 21px; height: 21px; font-weight: 600; background-color: inherit; border-radius: 50%;">
                        &dollar;
                    </span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
        <div style="float: left; margin-left: 10px;">
            <?= $__view('admin/social.php') ?>
        </div>
    </h2>

    <form method="POST" style="margin: 2rem;">
        <?php wp_nonce_field($nonce) ?>
        <?= $content ?>
        <?php submit_button(); ?>
    </form>
</div>
