<?php

if (!defined('ABSPATH')) {
    exit;
}

$photo       = $photo ?? [];
$index       = (int) ($index ?? 0);
$fancy_group = $fancy_group ?? 'photo-grid';

$src         = (string) ($photo['src'] ?? '');
$full        = (string) ($photo['full'] ?? $src);
$placeholder = (string) ($photo['placeholder'] ?? $src);
$alt         = (string) ($photo['alt'] ?? '');

if ($src === '') {
    return;
}
?>

<figure class="photo-grid__item">
    <?php
    if (function_exists('render_fancybox_image')) {
        render_fancybox_image([
            'src'        => $src,
            'full'       => $full,
            'alt'        => $alt,
            'group'      => $fancy_group,
            'img_class'  => 'photo-grid__image',
            'link_class' => 'photo-grid__link',
        ]);
    } else {
        ?>
        <img
            src="<?php echo esc_url($placeholder); ?>"
            data-src="<?php echo esc_url($src); ?>"
            alt="<?php echo esc_attr($alt); ?>"
            class="photo-grid__image lazy-img"
            loading="lazy"
            decoding="async"
        >
        <?php
    }
    ?>
</figure>
