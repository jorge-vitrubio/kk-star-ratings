<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }

    $type = $type ?? 'info';
    $dismissible = (bool) ($dismissible ?? false);
?>

<div class="notice notice-<?php echo esc_attr($type); ?>"<?php echo $dismissible ? ' is-dismissible' : ''; ?>>
    <p><?php echo esc_html($message); ?></p>
</div>
